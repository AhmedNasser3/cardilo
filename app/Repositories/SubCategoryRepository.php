<?php

namespace App\Repositories;

use App\Models\api\SubCategory;
use Illuminate\Support\Facades\Cache;

class SubCategoryRepository
{
    /**
     * Get cached category for a given subcategory.
     *
     * @param SubCategory $subCategory
     * @return \App\Models\Frontend\Category|null
     */
    public function cachedCategory(SubCategory $subCategory)
    {
        return Cache::remember(
            "sub_category:{$subCategory->id}:category",
            now()->addMinutes(10),
            fn () => $subCategory->category()->first()
        );
    }
}