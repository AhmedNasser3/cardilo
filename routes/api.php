<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\SeoMetaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\API\CategoryController;

/*
|--------------------------------------------------------------------------
| Authenticated User
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->get('/user', fn (Request $request) => $request->user());
Route::get('/user/account', [UserController::class, 'userAccount']);


/*
|--------------------------------------------------------------------------
| Categories
|--------------------------------------------------------------------------
*/
Route::get('/category/all', [CategoryController::class, 'index']); // بدون auth
Route::middleware('auth:sanctum')->apiResource('categories', CategoryController::class);


/*
|--------------------------------------------------------------------------
| Users
|--------------------------------------------------------------------------
*/
Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/', [UserController::class, 'store']);
    Route::get('/{user}', [UserController::class, 'show']);
    Route::put('/{user}', [UserController::class, 'update']);
    Route::delete('/{user}', [UserController::class, 'destroy']);
    Route::post('/update-order', [UserController::class, 'updateOrder']);
});


/*
|--------------------------------------------------------------------------
| Blogs
|--------------------------------------------------------------------------
*/
Route::prefix('blogs')->group(function () {
    Route::get('/', [BlogController::class, 'index']);             // جميع المقالات
    Route::post('/', [BlogController::class, 'store']);            // إنشاء
    Route::get('/{id}', [BlogController::class, 'show']);          // عرض واحد
    Route::put('/{id}', [BlogController::class, 'update']);        // تحديث
    Route::patch('/{id}', [BlogController::class, 'update']);      // تحديث
    Route::delete('/{id}', [BlogController::class, 'destroy']);    // حذف (soft/force)
    Route::post('/{id}/restore', [BlogController::class, 'restore']); // استعادة
});


/*
|--------------------------------------------------------------------------
| Reviews
|--------------------------------------------------------------------------
*/
Route::prefix('reviews')->group(function () {
    Route::get('/', [ReviewController::class, 'index']);           // جلب كل التقييمات
    Route::post('/', [ReviewController::class, 'store']);          // إنشاء تقييم
    Route::get('/{review}', [ReviewController::class, 'show']);    // عرض تقييم
    Route::put('/{review}', [ReviewController::class, 'update']);  // تحديث
    Route::delete('/{review}', [ReviewController::class, 'destroy']); // حذف
});


/*
|--------------------------------------------------------------------------
| Banners
|--------------------------------------------------------------------------
*/
Route::prefix('banners')->group(function () {
    Route::get('/', [BannerController::class, 'index']);
    Route::get('/trashed', [BannerController::class, 'trashed']);
    Route::get('/{id}', [BannerController::class, 'show']);
    Route::post('/', [BannerController::class, 'store']);
    Route::put('/{id}', [BannerController::class, 'update']);
    Route::delete('/{id}', [BannerController::class, 'destroy']);
    Route::post('/{id}/restore', [BannerController::class, 'restore']);
});


/*
|--------------------------------------------------------------------------
| SEO Meta
|--------------------------------------------------------------------------
*/
Route::prefix('seo-meta')->group(function () {
    Route::get('/', [SeoMetaController::class, 'index']);
    Route::post('/', [SeoMetaController::class, 'store']);
    Route::get('/{seoMeta}', [SeoMetaController::class, 'show']);
    Route::put('/{seoMeta}', [SeoMetaController::class, 'update']);
    Route::patch('/{seoMeta}', [SeoMetaController::class, 'update']);
    Route::delete('/{seoMeta}', [SeoMetaController::class, 'destroy']);
});


/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/
Route::get('/admin/dashboard', [DashboardController::class, 'index']);
