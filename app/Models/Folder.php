<?php

namespace App\Models;

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
            CompanyFolder::create([
                'company_id' => $company_id,
                'folder_id' => $folder->id
            ]);
        }

        return $folder;
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
        $folders = $this->subFolders()->with('files')->get();

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
