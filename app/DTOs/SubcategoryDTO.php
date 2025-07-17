<?php

namespace App\DTOs;

use Illuminate\Http\UploadedFile;

class SubCategoryDTO
{
    public function __construct(
        public string $name,
        public ?string $slug,
        public ?string $description,
        public ?array $metadata,
        public ?int $set_order,
        public ?UploadedFile $image,
        public ?string $category_id,
        public ?string $user_id,
        public ?bool $is_active,
        public ?string $publish_at,
        public ?string $approved_at,
    ) {}

    public static function fromArray(array $validated): self
    {
        return new self(
            name:        $validated['name'],
            slug:        $validated['slug'] ?? null,
            description: $validated['description'] ?? null,
            metadata:    $validated['metadata'] ?? null,
            set_order:   $validated['set_order'] ?? null,
            image:       $validated['image'] ?? null,
            category_id: $validated['category_id'] ?? null,
            user_id:     $validated['user_id'] ?? null,
            is_active:   $validated['is_active'] ?? true,
            publish_at:  $validated['publish_at'] ?? null,
            approved_at: $validated['approved_at'] ?? null,
        );
    }
}