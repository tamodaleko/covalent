<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'first_name' => 'required|string|max:191',
            'last_name' => 'required|string|max:191',
            'email' => 'required|email|max:191|unique:users',
            'company_id' => 'sometimes|nullable|integer|exists:companies,id',
            'password' => 'required|string|min:6|max:191|confirmed',
            'status' => 'required|integer',
            'is_admin' => 'required|boolean',
            'folders' => 'sometimes|array'
        ];
    }
}
