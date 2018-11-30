<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CompanyFolder extends Pivot
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'company_folder';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['company_id', 'folder_id'];
}
