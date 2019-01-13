<?php

namespace App\Http\Requests\File;

use Illuminate\Foundation\Http\FormRequest;

class DeleteFilesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return !auth()->guest();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'files' => 'required|array'
        ];
    }
}
