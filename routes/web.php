<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\Admin\SeoMetaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\RegisteredUserController;

/*
|--------------------------------------------------------------------------
| SPA Catch-all Route
|--------------------------------------------------------------------------
| أي طلب غير معروف يتم تحويله إلى view('app') لتعمل SPA React/Vue.
*/
Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');

/*
|--------------------------------------------------------------------------
| Welcome Page
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
| للوصول إلى لوحة التحكم بعد تسجيل الدخول والتفعيل.
*/
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Categories Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum'])->group(function () {
    Route::resource('categories', CategoryController::class);
});

/*
|--------------------------------------------------------------------------
| Site Settings Routes
|--------------------------------------------------------------------------
*/
Route::get('/sitesettings', [BannerController::class, 'index']);

/*
|--------------------------------------------------------------------------
| Blogs Routes
|--------------------------------------------------------------------------
*/
Route::prefix('blogs')->group(function () {

    // إرجاع الكل (مع ?with_deleted=1 لو عايزهم كلهم)
    Route::get('/', [BlogController::class, 'index']);

    // إنشاء blog
    Route::post('/', [BlogController::class, 'store']);

    // إرجاع blog واحد
    Route::get('/{id}', [BlogController::class, 'show']);

    // تحديث blog
    Route::put('/{id}', [BlogController::class, 'update']);
    Route::patch('/{id}', [BlogController::class, 'update']); // يدعم PATCH أيضًا

    // حذف (soft أو force مع ?force=1)
    Route::delete('/{id}', [BlogController::class, 'destroy']);

    // استرجاع blog محذوف
    Route::post('/{id}/restore', [BlogController::class, 'restore']);
});


Route::get('seo-meta', [SeoMetaController::class, 'index']);




Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index']);
});

Route::get('reviews', [ReviewController::class, 'index']);           // جلب كل التقييمات

Route::get('/admin/dashboard', [DashboardController::class, 'index']);
