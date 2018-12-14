<?php

namespace App\Models\Company;

use App\Models\Folder;
use App\Models\User\UserFolder;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'logo', 'info', 'status'];

    /**
     * Get the users for the company.
     */
    public function users()
    {
        return $this->hasMany('App\Models\User\User');
    }

    /**
     * The folders that belong to the company.
     */
    public function folders()
    {
        return $this->belongsToMany('App\Models\Folder');
    }

    /**
     * Get company list.
     *
     * @param bool $prepend
     * @return array
     */
    public static function getList($prepend = false)
    {
        $list = [];

        if ($prepend) {
            $list[''] = 'Select Company';
        }

        foreach (static::all() as $company) {
            $list[$company->id] = $company->name;
        }

        return $list;
    }

    /**
     * Get status list.
     *
     * @return array
     */
    public static function getStatusList()
    {
        return [
            static::STATUS_ACTIVE => 'Active',
            static::STATUS_INACTIVE => 'In-Active'
        ];
    }

    /**
     * Add new company.
     *
     * @param array $data
     * @param \Illuminate\Http\UploadedFile $image
     * @return bool
     */
    public static function add($data, $image)
    {
        if ($image) {
            $logo = static::uploadLogo($image);

            if (!$logo) {
                return false;
            }

            $data['logo'] = $logo;
        }

        return static::create($data);
    }

    /**
     * Edit company.
     *
     * @param array $data
     * @param \Illuminate\Http\UploadedFile $image
     * @return bool
     */
    public function edit($data, $image)
    {
        if ($image) {
            $logo = static::uploadLogo($image);

            if (!$logo) {
                return false;
            }

            $data['logo'] = $logo;
        }

        return $this->update($data);
    }

    /**
     * Upload logo.
     *
     * @param \Illuminate\Http\UploadedFile $image
     * @return bool|string
     */
    public static function uploadLogo($image)
    {
        $name = md5(time() . '_' . auth()->user()->id) . '.' . $image->getClientOriginalExtension();

        try {
            $image->move('uploads/images/companies', $name);
        } catch (\Exception $e) {
            return false;
        }

        return $name;
    }

    /**
     * Get allowed folder structure.
     *
     * @return array
     */
    public function getAllowedFolderStructure()
    {
        return Folder::getStructure($this->getAllowedFolders());
    }

    /**
     * Update permissions.
     *
     * @param array $folders
     * @return bool
     */
    public function updatePermissions($folders)
    {
        if ($this->folders()->sync($folders)) {
            $users = $this->users()->pluck('id')->toArray();
            UserFolder::whereIn('user_id', $users)->whereNotIn('folder_id', $folders)->delete();

            return true;
        }

        return false;
    }

    /**
     * Get allowed folders.
     *
     * @return array
     */
    public function getAllowedFolders()
    {
        return $this->folders()->pluck('folder_id')->toArray();
    }
}
