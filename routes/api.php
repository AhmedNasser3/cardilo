<?php

use App\Http\Controllers\API\SubCategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\Admin\SeoMetaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Api\NotificationController;

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
Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/trashed', [CategoryController::class, 'trashed'])->name('categories.trashed');
    Route::get('/{id}', [CategoryController::class, 'show'])->name('categories.show');
    Route::post('/', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::post('/{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
});
/*
|--------------------------------------------------------------------------
| SubCategories
|--------------------------------------------------------------------------
*/
Route::prefix('subcategories')->group(function () {
    Route::get('/', [SubCategoryController::class, 'index']);
    Route::get('/trashed', [SubCategoryController::class, 'trashed']);
    Route::get('/{subCategory}', [SubCategoryController::class, 'show']);
    Route::post('/', [SubCategoryController::class, 'store']);
    Route::put('/{subCategory}', [SubCategoryController::class, 'update']);
    Route::delete('/{subCategory}', [SubCategoryController::class, 'destroy']);
    Route::post('/{subCategory}/restore', [SubCategoryController::class, 'restore']);
    Route::post('/{subCategory}/move-up', [SubCategoryController::class, 'moveUp']);
    Route::post('/{subCategory}/move-down', [SubCategoryController::class, 'moveDown']);
});

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


/*
|--------------------------------------------------------------------------
| Notofication
|--------------------------------------------------------------------------
*/

Route::get('/notifications', [NotificationController::class, 'index']);
Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead']);
