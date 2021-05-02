<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemEditRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:1', 'max:255'],
            'price' => ['required', 'numeric'],
            'description' => ['nullable', 'string'],
            'category_id' => ['required', 'numeric', 'exists:categories,id'],
            'main_image' => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,gif,bpm,webp'],
            'images' => ['array'],
            'images.*' => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,gif,bpm,webp'],
        ];
    }
}
