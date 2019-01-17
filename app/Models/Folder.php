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
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

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

        while($parent) {
            $path = $parent->name . '/' . $path;
            $parent = $parent->parentFolder;
        }

        return $path;
    }

    /**
     * Get valid folder name.
     *
     * @param int $parent_folder_id
     * @param string $name
     * @return string
     */
    public static function getValidName($parent_folder_id, $name)
    {
        $folder = static::where([
            'parent_folder_id' => $parent_folder_id,
            'name' => $name
        ])->first();

        if ($folder) {
            return $folder->getCopyName($parent_folder_id);
        }

        return $name;
    }

    /**
     * Get copy name.
     *
     * @param int $parent_folder_id
     * @return string
     */
    public function getCopyName($parent_folder_id)
    {
        $append = 0;

        do {
            $name = !$append ? $this->name : $this->name . '_' . $append;
            
            $folder = self::where([
                'parent_folder_id' => $parent_folder_id,
                'name' => $name
            ])->first();
            
            $append++;
        } while (!empty($folder));

        return $name;
    }

    /**
     * Create copy.
     *
     * @param int $parent_folder_id
     * @return self
     */
    public function createCopy($parent_folder_id)
    {
        $folder = self::create([
            'parent_folder_id' => $parent_folder_id,
            'name' => $this->getCopyName($parent_folder_id),
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
            static::attachToCompany($folder->id, $company_id);
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

        static::attachToCompany($this->id, $company->id);

        if (!$user->is_admin) {
            static::attachToUser($this->id, $user->id);
        }
    }

    /**
     * Attach folder to company.
     *
     * @param int $folder_id
     * @param int $company_id
     * @return bool
     */
    public static function attachToCompany($folder_id, $company_id)
    {
        return CompanyFolder::create([
            'company_id' => $company_id,
            'folder_id' => $folder_id
        ]);
    }

    /**
     * Attach folder to user.
     *
     * @param int $folder_id
     * @param int $user_id
     * @return bool
     */
    public static function attachToUser($folder_id, $user_id)
    {
        return UserFolder::create([
            'user_id' => $user_id,
            'folder_id' => $folder_id
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

    /**
     * Get allowed folders by company.
     *
     * @param \App\Models\Company\Company
     * @return static[]
     */
    public static function getAllowedByCompany($company)
    {
        if (!$company) {
            return [];
        }

        $allowed = $company->getAllowedFolders();

        $query = static::whereIn('id', $allowed)
            ->orderBy('parent_folder_id')
            ->orderBy('created_at');

        $user = auth()->user();

        if (!$user->is_admin) {
            $allowed = array_intersect($allowed, $user->getAllowedFolders());
            $query->whereIn('id', $allowed);
        }

        return $query->get();
    }

    /**
     * Get source files.
     *
     * @return array
     */
    public function getFilesPath()
    {
        $files = $this->getFolderFilesPath();

        foreach ($this->subFolders()->get() as $folder) {
            $files = $files + $folder->getFilesPath();
        }

        return $files;
    }

    /**
     * Get folder source files.
     *
     * @return array
     */
    public function getFolderFilesPath()
    {
        $files = [];

        foreach ($this->files as $file) {
            $files[$file->id]['path'] = $file->folder->getPath() . '/' . $file->fullName;
        }

        return $files;
    }
}
