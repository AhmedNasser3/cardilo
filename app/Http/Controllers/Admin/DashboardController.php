<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Admin\Blog;
use App\Models\Admin\Banner;
use App\Models\Admin\Review;
use Illuminate\Http\Request;
use App\Models\frontend\Category;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
     public function index()
    {
        $data = [
            'users_count'      => User::count(),
            'blogs_count'      => Blog::count(),
            'reviews_count'    => Review::count(),
            'categories_count' => Category::count(),
            'banners_count'    => Banner::count(),
            'new_users_today'  => User::whereDate('created_at', today())->count(),
            'new_blogs_today'  => Blog::whereDate('created_at', today())->count(),
            'new_reviews_today'=> Review::whereDate('created_at', today())->count(),
        ];

        return response()->json($data);
    }
}
