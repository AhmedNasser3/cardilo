<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use App\DTOs\CategoryDTO;
use Carbon\Carbon;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:255'],
            'slug'        => ['nullable', 'string', 'max:255', 'unique:categories,slug'],
            'description' => ['nullable', 'string'],
            'metadata'    => ['nullable', 'array'],
            'metadata.*'  => ['nullable', 'string'],
            'set_order'   => ['nullable', 'integer', 'min:0'],
            'image'       => ['nullable', 'image', 'max:2048'],
            'parent_id'   => ['nullable', 'uuid', 'exists:categories,id'],
            'user_id'     => ['nullable', 'exists:users,id'],
            'is_active'   => ['nullable', 'boolean'], // يبقى nullable لأنك ستعينه لاحقًا
            'publish_at'  => ['nullable', 'date'],
            'approved_at' => ['nullable', 'date'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if (!$this->slug && $this->name) {
            $this->merge(['slug' => Str::slug($this->name)]);
        }

        $now = Carbon::now()->toDateTimeString();

        if (!$this->publish_at) {
            $this->merge(['publish_at' => $now]);
        }

        if (!$this->approved_at) {
            $this->merge(['approved_at' => $now]);
        }

        if (is_null($this->is_active)) {
            $this->merge(['is_active' => true]);
        }

        // إذا الميتاداتا جاية كـ JSON string (شائع من React)، فك تشفيرها
        if (is_string($this->metadata)) {
            $decoded = json_decode($this->metadata, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $this->merge(['metadata' => $decoded]);
            }
        }
    }

    public function toDTO(): CategoryDTO
    {
        return new CategoryDTO(
            name: $this->input('name'),
            slug: $this->input('slug'),
            description: $this->input('description'),
            metadata: $this->input('metadata'),
            set_order: $this->input('set_order'),
            image: $this->file('image'),
            parent_id: $this->input('parent_id'),
            user_id: $this->input('user_id'),
            is_active: $this->boolean('is_active'),
            publish_at: $this->input('publish_at'),
            approved_at: $this->input('approved_at'),
        );
    }
}