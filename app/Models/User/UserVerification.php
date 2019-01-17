<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserVerification extends Model
{
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
    protected $fillable = ['user_id', 'token', 'used'];

    /**
     * Get the user associated with the verification.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User\User');
    }
}
