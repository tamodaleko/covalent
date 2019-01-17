<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'logo' => 'nullable|image',
            'name' => 'required|string|max:191|unique:companies,name,' . $this->route()->company->id,
            'status' => 'required|integer',
            'users' => 'nullable|array',
            'folders' => 'nullable|array'
        ];
    }
}
