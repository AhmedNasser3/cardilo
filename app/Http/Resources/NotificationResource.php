<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->data['title'] ?? '',
            'body' => $this->data['body'] ?? '',
            'extra' => $this->data['extra'] ?? [],
            'read_at' => $this->read_at,
            'created_at' => $this->created_at,
        ];
    }
}
