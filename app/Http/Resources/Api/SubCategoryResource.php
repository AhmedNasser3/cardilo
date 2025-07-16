<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'name'         => $this->name,
            'slug'         => $this->slug,
            'description'  => $this->description,
            'image'        => $this->image,
            'metadata'     => $this->metadata,
            'set_order'    => $this->set_order,
            'category_id'  => $this->category_id,
            'user_id'      => $this->user_id,
            'is_active'    => $this->is_active,
            'publish_at'   => $this->publish_at,
            'approved_at'  => $this->approved_at,
            'created_at'   => $this->created_at,
            'updated_at'   => $this->updated_at,
        ];
    }
}