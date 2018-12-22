<?php

namespace App\Models\User;

use App\Models\File;
use App\Models\Folder;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id', 'first_name', 'last_name', 'avatar', 'email', 'password', 'is_admin', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the company associated with the user.
     */
    public function company()
    {
        return $this->belongsTo('App\Models\Company\Company');
    }

    /**
     * The folders that belong to the user.
     */
    public function folders()
    {
        return $this->belongsToMany('App\Models\Folder', 'user_folder');
    }

    /**
     * Get the user's name.
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Get status list.
     *
     * @var array
     */
    public static function getStatusList()
    {
        return [
            static::STATUS_ACTIVE => 'Active',
            static::STATUS_INACTIVE => 'In-Active'
        ];
    }

    /**
     * Edit user.
     *
     * @param array $data
     * @param \Illuminate\Http\UploadedFile $image
     * @return bool
     */
    public function edit($data, $image)
    {
        if ($image) {
            $avatar = static::uploadAvatar($image);

            if (!$avatar) {
                return false;
            }

            $data['avatar'] = $avatar;
        }

        return $this->update($data);
    }

    /**
     * Upload avatar.
     *
     * @param \Illuminate\Http\UploadedFile $image
     * @return bool|string
     */
    public static function uploadAvatar($image)
    {
        $name = md5(time() . '_' . auth()->user()->id) . '.' . $image->getClientOriginalExtension();

        try {
            $image->move('uploads/images/users', $name);
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
        if (!$this->getAllowedFolders()) {
            return [];
        }

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
        $folders = $folders ?: [];

        return $this->folders()->sync($folders);
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

    /**
     * Grant default permissions.
     *
     * @return bool
     */
    public function grantDefaultPermissions()
    {
        if (!$this->company) {
            return false;
        }

        return $this->updatePermissions($this->company->getAllowedFolders());
    }

    /**
     * Get allowed file search.
     *
     * @param string $search
     * @return array
     */
    public function getAllowedFileSearch($search)
    {
        if (!$this->getAllowedFolders()) {
            return [];
        }

        return File::search($search, $this->getAllowedFolders());
    }

    /**
     * Add permissions.
     *
     * @param array $folders
     * @return bool
     */
    public function addPermissions($folders)
    {
        return $this->folders()->sync($folders, false);
    }
}
