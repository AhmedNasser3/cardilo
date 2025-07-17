<?php

namespace App\Listeners;

use App\Events\SubCategoryCreated;

class HandleSubCategoryCreated
{
    public function handle(SubCategoryCreated $event): void
    {
        \Log::info("SubCategory created: {$event->subCategory->id}");
    }
}