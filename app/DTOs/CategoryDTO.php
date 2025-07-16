<?php

namespace App\DTOs;

use App\Models\Frontend\Category;
use Illuminate\Http\UploadedFile;

class CategoryDTO
{
    public function __construct(
        public string $name,
        public ?string $slug,
        public ?string $description,
        public ?array $metadata,
        public ?int $set_order,
        public ?UploadedFile $image,
        public ?string $parent_id,
        public ?string $user_id,
        public ?bool $is_active,
        public ?string $publish_at,
        public ?string $approved_at,
    ) {}
    public function createCategory(CategoryDTO $dto): Category
{
    $imagePath = null;

    if ($dto->image instanceof \Illuminate\Http\UploadedFile) {
        $imagePath = $dto->image->store('categories', 'public');
    }

    return Category::create([
        'name'        => $dto->name,
        'slug'        => $dto->slug,
        'description' => $dto->description,
        'metadata'    => $dto->metadata,
        'set_order'   => $dto->set_order ?? 0,
        'image'       => $imagePath,
        'parent_id'   => $dto->parent_id,
        'user_id'     => $dto->user_id,
        'is_active'   => $dto->is_active ?? true,
        'publish_at'  => $dto->publish_at,
        'approved_at' => $dto->approved_at,
    ]);
}

}