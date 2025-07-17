<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubCategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'image' => $this->image,
            'metadata' => $this->metadata,
            'set_order' => $this->set_order,
            'is_active' => $this->is_active,
            'publish_at' => $this->publish_at,
            'approved_at' => $this->approved_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'category' => $this->category?->only(['id', 'name']),
            'user' => $this->user?->only(['id', 'name']),
        ];
    }
}