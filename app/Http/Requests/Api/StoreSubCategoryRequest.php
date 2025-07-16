<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use App\DTOs\SubCategoryDTO;

class StoreSubCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized.
     */
    public function authorize(): bool
    {
        return true; // أو ضع شروط صلاحيات هنا
    }

    /**
     * Get the validation rules.
     */
    public function rules(): array
    {
        return [
            'name'         => 'required|string|max:255',
            'slug'         => 'nullable|string|max:255|unique:sub_categories,slug,' . $this->route('id'),
            'description'  => 'nullable|string',
            'metadata'     => 'nullable|array',
            'set_order'    => 'nullable|integer',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'category_id'  => 'nullable|exists:categories,id',
            'user_id'      => 'nullable|exists:users,id',
            'is_active'    => 'nullable|boolean',
            'publish_at'   => 'nullable|date',
            'approved_at'  => 'nullable|date',
        ];
    }

    /**
     * Transform validated data to DTO.
     */
    public function toDTO(): SubCategoryDTO
    {
        $validated = $this->validated();

        return new SubCategoryDTO(
            name:        $validated['name'],
            slug:        $validated['slug'] ?? null,
            description: $validated['description'] ?? null,
            metadata:    $validated['metadata'] ?? null,
            set_order:   $validated['set_order'] ?? null,
            image:       $this->file('image'),
            category_id: $validated['category_id'] ?? null,
            user_id:     $validated['user_id'] ?? null,
            is_active:   $validated['is_active'] ?? true,
            publish_at:  $validated['publish_at'] ?? null,
            approved_at: $validated['approved_at'] ?? null,
        );
    }
}
