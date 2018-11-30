<?php

namespace App\Models\Company;

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
     * @var array
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
     * @var array
     */
    public static function getStatusList()
    {
        return [
            static::STATUS_ACTIVE => 'Active',
            static::STATUS_INACTIVE => 'In-Active'
        ];
    }
}
