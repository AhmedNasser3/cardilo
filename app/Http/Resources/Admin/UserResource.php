<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        return collect([
            'id', 'name', 'email', 'role', 'status','order',
            'avatar', 'notifications_enabled', 'notification_type',
            'badges', 'permissions', 'session_history',
            'created_at', 'updated_at'
        ])->mapWithKeys(fn ($field) => [$field => $this->$field])->all();
    }
}
