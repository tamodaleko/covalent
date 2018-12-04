<?php

namespace App\Http\Requests\Folder;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFolderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'parent_folder_id' => 'nullable|integer|exists:folders,id',
            'name' => 'sometimes|string|max:255',
            'tag' => 'nullable|string|max:255',
            'status' => 'sometimes|integer'
        ];
    }
}
