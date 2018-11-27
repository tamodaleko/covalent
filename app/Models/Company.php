<?php

namespace App\Models;

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
