<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserSummaryResource extends JsonResource
{
    /**
     * Transform the user resource to array.
     */
    public function toArray($request): array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'email'         => $this->email,
            'role'          => $this->role,
            'status'        => $this->status,
            'last_login_at' => optional($this->last_login_at)->toDateTimeString(),
            'login_count'   => $this->login_count,
            'avatar_url'    => $this->avatarUrl(),
            'badges'        => $this->badgesArray(),
            'permissions'   => $this->permissions ?? [],
            'notifications' => [
                'enabled' => (bool) $this->notifications_enabled,
                'type'    => $this->notification_type,
            ],
        ];
    }

    /**
     * Get avatar URL or fallback to gravatar or placeholder.
     */
    protected function avatarUrl(): string
    {
        if (!empty($this->avatar)) {
            return asset("storage/{$this->avatar}");
        }

        if (!empty($this->email)) {
            $hash = md5(strtolower(trim($this->email)));
            return "https://www.gravatar.com/avatar/{$hash}?s=200&d=identicon";
        }

        return "https://i.pravatar.cc/150?u={$this->id}";
    }

    /**
     * Convert badges string into array.
     */
    protected function badgesArray(): array
    {
        if (empty($this->badges)) {
            return [];
        }

        return array_map('trim', explode(',', $this->badges));
    }
}
