<?php

namespace App\Models;

use App\Models\Company\CompanyFolder;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    const STATUS_NOT_STARTED = 0;
    const STATUS_IN_PROGRESS = 1;
    const STATUS_COMPLETE = 2;

    /**
     * Sub folders.
     *
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
     * @return void
     */
    public static function addForCompany($name, $company_id, $parent_folder_id = null)
    {
        $folder = static::create([
            'parent_folder_id' => $parent_folder_id,
            'name' => $name,
            'status' => static::STATUS_NOT_STARTED
        ]);

        CompanyFolder::create([
            'company_id' => $company_id,
            'folder_id' => $folder->id
        ]);
    }

    /**
     * Get sub folder structure.
     *
     * @return array
     */
    public function getSubFolderStructure()
    {
        $folders = $this->subFolders()->with('files')->where('parent_folder_id', $this->id)->get();

        foreach ($folders as $folder) {
            $folder->subFolders = $folder->getSubFolderStructure($folder->id);
        }

        return $folders;
    }
}
