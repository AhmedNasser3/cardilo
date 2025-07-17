<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubCategoryRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:sub_categories,slug,' . $this->route('sub_category'),
            'description' => 'nullable|string',
            'metadata' => 'nullable|array',
            'set_order' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'category_id' => 'nullable|exists:categories,id',
            'user_id' => 'nullable|exists:users,id',
            'is_active' => 'nullable|boolean',
            'publish_at' => 'nullable|date',
            'approved_at' => 'nullable|date',
        ];
    }
}