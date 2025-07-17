<?php

namespace App\Models\Scopes;

use App\Enums\Api\ProjectStatus;

trait HasStatusScopes
{
    public function scopePublished($query)
    {
        return $query->whereNotNull('publish_at')
                     ->where('publish_at', '<=', now());
    }

    public function scopeWithStatus($query, string|ProjectStatus $status)
    {
        if ($status instanceof ProjectStatus) {
            $status = $status->value;
        }

        return $query->where('status', $status);
    }
}