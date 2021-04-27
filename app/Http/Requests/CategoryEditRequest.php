<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryEditRequest extends FormRequest
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
        $id = $this->route('category')->id;

        return [
            'name' => ['required', 'string', 'min:1', 'max:255'],
            'category_id' => ['nullable', 'numeric', 'exists:categories,id', 'not_in:' . $id],
        ];
    }
}
