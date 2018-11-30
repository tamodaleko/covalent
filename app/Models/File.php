<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['folder_id', 'name', 'extension', 'size'];

    /**
     * Get the folder associated with the file.
     */
    public function folder()
    {
        return $this->belongsTo('App\Models\Folder');
    }
}
