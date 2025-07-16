<?php

namespace App\Events;

use App\Models\api\SubCategory;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SubCategoryCreated
{
    use Dispatchable, SerializesModels;

    public SubCategory $subCategory;

    /**
     * Create a new event instance.
     */
    public function __construct(SubCategory $subCategory)
    {
        $this->subCategory = $subCategory;
    }
}