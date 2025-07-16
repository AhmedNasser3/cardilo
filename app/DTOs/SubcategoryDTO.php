<?php

namespace App\DTOs;

use App\Models\api\SubCategory;
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

    /**
     * Create a SubCategory from the DTO.
     *
     * @return SubCategory
     */
    public function create(): SubCategory
    {
        $imagePath = null;

        if ($this->image instanceof UploadedFile) {
            $imagePath = $this->image->store('sub_categories', 'public');
        }

        return SubCategory::create([
            'name'         => $this->name,
            'slug'         => $this->slug,
            'description'  => $this->description,
            'metadata'     => $this->metadata,
            'set_order'    => $this->set_order ?? 0,
            'image'        => $imagePath,
            'category_id'  => $this->category_id,
            'user_id'      => $this->user_id,
            'is_active'    => $this->is_active ?? true,
            'publish_at'   => $this->publish_at,
            'approved_at'  => $this->approved_at,
        ]);
    }
}
