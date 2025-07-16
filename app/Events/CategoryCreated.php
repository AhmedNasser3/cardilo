<?php

namespace App\Events;

use App\Models\Frontend\Category;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CategoryCreated
{
    use Dispatchable, SerializesModels;

    public Category $category;

    /**
     * Create a new event instance.
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
    }
}
