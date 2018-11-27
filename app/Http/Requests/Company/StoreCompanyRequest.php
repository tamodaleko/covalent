<?php

namespace App\Http\Requests\Company;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'logo' => 'required|image',
            'name' => 'required|string|max:191',
            'info' => 'required|string|max:191',
            'status' => 'required|integer'
        ];
    }
}
