<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserFolder extends Pivot
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_folder';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'folder_id'];
}
