<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

class BrandStoreRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'slogan' => 'nullable|string|max:255',
            'summery' => 'nullable|string',
            'icon' => 'nullable|image|max:255',
            'banner' => 'nullable|image|max:255',
            'featured' => 'nullable|boolean',
            'top' => 'nullable|boolean',
            'order_level' => 'required|integer|min:0',
            'level' => 'nullable|integer|min:0',
            'status' => ['nullable', Rule::in(['published', 'cancel', 'pending', 'deleted'])],
        ];
    }
}
