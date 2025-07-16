<?php

namespace App\Http\Resources\Api;

use App\Http\Resources\UserSummaryResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'          => $this->id,
            'slug'        => $this->slug,
            'name'        => $this->name,
            'description' => $this->whenNotNull($this->description),
            'metadata'    => $this->whenNotNull($this->metadata),
            'image_url'   => $this->imageUrl(),
            'set_order'   => $this->set_order,
            'parent_id'   => $this->parent_id,
            'user'        => new UserSummaryResource($this->whenLoaded('user')),
            'children'    => CategoryResource::collection($this->whenLoaded('children')),
            'is_active'   => $this->is_active,
            'publish_at'  => optional($this->publish_at)?->toDateTimeString(),
            'approved_at' => optional($this->approved_at)?->toDateTimeString(),
            'created_at'  => optional($this->created_at)?->toDateTimeString(),
            'updated_at'  => optional($this->updated_at)?->toDateTimeString(),
        ];
    }

    protected function imageUrl(): ?string
    {
        if (!empty($this->image)) {
            return asset("storage/{$this->image}");
        }

        return asset('images/default-category.png');
    }
}
