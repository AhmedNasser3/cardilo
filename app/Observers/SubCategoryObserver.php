<?php

namespace App\Observers;

use App\Models\api\SubCategory;
use Illuminate\Support\Str;
use App\Events\SubCategoryCreated;

class SubCategoryObserver
{
    /**
     * Handle the SubCategory "creating" event.
     */
    public function creating(SubCategory $subCategory): void
    {
        if (empty($subCategory->id)) {
            $subCategory->id = (string) Str::uuid();
        }
    }

    /**
     * Handle the SubCategory "created" event.
     */
    public function created(SubCategory $subCategory): void
    {
        event(new SubCategoryCreated($subCategory));
    }
}