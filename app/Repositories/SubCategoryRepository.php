<?php

namespace App\Repositories;

use App\Models\api\SubCategory;
use Illuminate\Support\Facades\Cache;

class SubCategoryRepository
{
    public function cachedCategory(SubCategory $subCategory)
    {
        return Cache::remember(
            "sub_category:{$subCategory->id}:category",
            now()->addMinutes(10),
            fn () => $subCategory->category()->first()
        );
    }
}