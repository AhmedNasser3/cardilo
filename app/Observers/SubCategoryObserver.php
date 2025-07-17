<?php

namespace App\Observers;

use App\Events\SubCategoryCreated;
use App\Models\api\SubCategory;
use Illuminate\Support\Str;

class SubCategoryObserver
{
    public function creating(SubCategory $subCategory): void
    {
        if (!$subCategory->id) {
            $subCategory->id = (string) Str::uuid();
        }
    }

    public function created(SubCategory $subCategory): void
    {
        event(new SubCategoryCreated($subCategory));
    }
}