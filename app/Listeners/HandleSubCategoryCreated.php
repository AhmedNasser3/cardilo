<?php

// app/Listeners/HandleSubCategoryCreated.php

namespace App\Listeners;

use App\Events\SubCategoryCreated;

class HandleSubCategoryCreated
{
    /**
     * Handle the event.
     */
    public function handle(SubCategoryCreated $event): void
    {
        $subCategory = $event->subCategory;

        // 👇 هنا تكتب أي منطق تريده عند إنشاء SubCategory
        // مثال: إرسال إشعار أو Log
        \Log::info("SubCategory created: {$subCategory->id}");
    }
}
