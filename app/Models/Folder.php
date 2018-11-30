<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['parent_folder_id', 'name', 'tag', 'status'];

    /**
     * Get the files for the folder.
     */
    public function files()
    {
        return $this->hasMany('App\Models\File');
    }
}
