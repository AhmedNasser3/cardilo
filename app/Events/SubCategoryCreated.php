<?php

namespace App\Events;

use App\Models\api\SubCategory;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SubCategoryCreated
{
    use Dispatchable, SerializesModels;

    public function __construct(public SubCategory $subCategory) {}
}