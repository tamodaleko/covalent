<?php

namespace App\Models;

use App\Models\Company\Company;
use App\Models\Company\CompanyFolder;
use App\Models\User\UserFolder;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    const STATUS_NOT_STARTED = 0;
    const STATUS_IN_PROGRESS = 1;
    const STATUS_COMPLETE = 2;

    /**
     * @var array
     */
    public $subFolders;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['parent_folder_id', 'name', 'tag', 'status'];

    /**
     * Get the parent folder associated with the folder.
     */
    public function parentFolder()
    {
        return $this->belongsTo('App\Models\Folder', 'parent_folder_id');
    }

    /**
     * Get the sub folders for the folder.
     */
    public function subFolders()
    {
        return $this->hasMany('App\Models\Folder', 'parent_folder_id');
    }

    /**
     * Get the files for the folder.
     */
    public function files()
    {
        return $this->hasMany('App\Models\File');
    }

    /**
     * Get status list.
     *
     * @return array
     */
    public static function getStatusList()
    {
        return [
            static::STATUS_NOT_STARTED => 'Not Started',
            static::STATUS_IN_PROGRESS => 'In Progress',
            static::STATUS_COMPLETE => 'Complete'
        ];
    }

    /**
     * Get status tag.
     *
     * @return string
     */
    public function getStatusTag()
    {
        switch ($this->status) {
            case static::STATUS_NOT_STARTED:
                return 'notstarted';
            case static::STATUS_IN_PROGRESS:
                return 'inprogress';
            case static::STATUS_COMPLETE:
                return 'complete';
        }
    }

    /**
     * Get path.
     *
     * @return string
     */
    public function getPath()
    {
        $path = $this->name;
        $parent = $this->parentFolder;

        if (!$parent) {
            return $path;
        }

        $path = $parent->name . '/' . $path;

        do {
            $parent = $parent->parentFolder;

            if ($parent) {
                $path = $parent->name . '/' . $path;
            }
        } while ($parent);

        return $path;
    }

    /**
     * Get copy name.
     *
     * @return string
     */
    public function getCopyName()
    {
        $append = 1;

        do {
            $name = $this->name . '_' . $append;
            $folder = self::where('name', $name)->where('parent_folder_id', $this->parent_folder_id)->first();
            $append++;
        } while (!empty($folder));

        return $name;
    }

    /**
     * Get copy.
     *
     * @return static
     */
    public function createCopy()
    {
        $folder = static::create([
            'parent_folder_id' => $this->parent_folder_id,
            'name' => $this->getCopyName(),
            'tag' => $this->tag,
            'status' => $this->status
        ]);

        if ($folder) {
            $folder->grantPermissions();
        }

        return $folder;
    }

    /**
     * Replicate sub folders.
     *
     * @param int $folder_copy_id
     * @return array
     */
    public function replicateSubFolders($folder_copy_id)
    {
        $files = $this->replicateFiles($folder_copy_id);

        foreach ($this->subFolders()->get() as $folder) {
            $newFolder = $folder->replicate();
            $newFolder->parent_folder_id = $folder_copy_id;

            if ($newFolder->save()) {
                $newFolder->grantPermissions();
                $files = $files + $folder->replicateSubFolders($newFolder->id);
            }
        }

        return $files;
    }

    /**
     * Replicate files.
     *
     * @param int $folder_copy_id
     * @return array
     */
    public function replicateFiles($folder_copy_id)
    {
        $files = [];

        foreach ($this->files as $file) {
            $newFile = $file->replicate();
            $newFile->folder_id = $folder_copy_id;
            
            if ($newFile->save()) {
                $files[$file->id] = [
                    'sourcePath' => $file->folder->getPath() . '/' . $file->fullName,
                    'targetPath' => $newFile->folder->getPath() . '/' . $newFile->fullName
                ];
            }
        }

        return $files;
    }

    /**
     * Add folder and attach to company.
     *
     * @param string $name
     * @param integer $company_id
     * @param integer|null $parent_folder_id
     * @return true
     */
    public static function addForCompany($name, $company_id, $parent_folder_id = null)
    {
        $folder = static::create([
            'parent_folder_id' => $parent_folder_id,
            'name' => $name
        ]);

        if ($folder) {
            $this->attachToCompany($company_id);
        }

        return $folder;
    }

    /**
     * Grant permissions.
     *
     * @return void
     */
    public function grantPermissions()
    {
        $user = auth()->user();
        
        if ($user->is_admin) {
            $company = Company::find(request()->session()->get('company_id'));
        } else {
            $company = $user->company;
        }

        $this->attachToCompany($company->id);

        if (!$user->is_admin) {
            $this->attachToUser($user->id);
        }
    }

    /**
     * Attach folder to user.
     *
     * @param int $company_id
     * @return bool
     */
    public function attachToCompany($company_id)
    {
        return CompanyFolder::create([
            'company_id' => $company_id,
            'folder_id' => $this->id
        ]);
    }

    /**
     * Attach folder to user.
     *
     * @param int $user_id
     * @return bool
     */
    public function attachToUser($user_id)
    {
        return UserFolder::create([
            'user_id' => $user_id,
            'folder_id' => $this->id
        ]);
    }

    /**
     * Get structure.
     *
     * @return array
     */
    public static function getStructure($allowed = null)
    {
        $data = [];
        $folders = static::with('files')->whereNull('parent_folder_id')->orderBy('created_at')->get();

        foreach ($folders as $folder) {
            $subFolders = $folder->getSubFolderStructure($allowed);

            if ($allowed && !in_array($folder->id, $allowed)) {
                foreach ($subFolders as $subFolder) {
                    $data[] = $subFolder;
                }
            } else {
                $folder->subFolders = $subFolders;
                $data[] = $folder;
            }
        }

        return $data;
    }

    /**
     * Get sub folder structure.
     *
     * @return array
     */
    public function getSubFolderStructure($allowed)
    {
        $data = [];
        $folders = $this->subFolders()->with('files')->orderBy('created_at')->get();

        foreach ($folders as $folder) {
            $subFolders = $folder->getSubFolderStructure($allowed);

            if ($allowed && !in_array($folder->id, $allowed)) {
                foreach ($subFolders as $subFolder) {
                    $data[] = $subFolder;
                }
            } else {
                $folder->subFolders = $subFolders;
                $data[] = $folder;
            }
        }

        return $data;
    }
}
