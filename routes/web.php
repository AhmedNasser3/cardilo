<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\Admin\SeoMetaController;
use App\Http\Controllers\Admin\DashboardController;
/*
|--------------------------------------------------------------------------
| SPA Catch-all Route
|--------------------------------------------------------------------------
| أي طلب غير معروف يتم تحويله إلى view('app') لتعمل SPA React/Vue
*/
Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');
/*
|--------------------------------------------------------------------------
| Welcome Page
|--------------------------------------------------------------------------
| الصفحة الترحيبية الافتراضية
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
| للوصول إلى لوحة التحكم بعد تسجيل الدخول وتفعيل الحساب
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
| Admin Dashboard API
|--------------------------------------------------------------------------
| بيانات الاحصائيات في لوحة التحكم
*/
Route::get('/admin/dashboard', [DashboardController::class, 'index']);

/*
|--------------------------------------------------------------------------
| Categories Routes
|--------------------------------------------------------------------------
| إدارة التصنيفات
*/
Route::middleware(['auth:sanctum'])->group(function () {
    Route::resource('categories', CategoryController::class);
});

/*
|--------------------------------------------------------------------------
| Site Settings Routes
|--------------------------------------------------------------------------
| إعدادات الموقع
*/
Route::get('/sitesettings', [BannerController::class, 'index']);

/*
|--------------------------------------------------------------------------
| Blogs Routes
|--------------------------------------------------------------------------
| إدارة المقالات
*/
Route::prefix('blogs')->group(function () {
    Route::get('/', [BlogController::class, 'index']);         // كل المقالات
    Route::post('/', [BlogController::class, 'store']);        // إنشاء مقالة
    Route::get('/{id}', [BlogController::class, 'show']);      // مقالة واحدة
    Route::put('/{id}', [BlogController::class, 'update']);    // تحديث مقالة
    Route::patch('/{id}', [BlogController::class, 'update']);  // تحديث مقالة
    Route::delete('/{id}', [BlogController::class, 'destroy']); // حذف (soft/force)
    Route::post('/{id}/restore', [BlogController::class, 'restore']); // استرجاع
});

/*
|--------------------------------------------------------------------------
| SEO Meta Routes
|--------------------------------------------------------------------------
| إدارة بيانات SEO
*/
Route::get('seo-meta', [SeoMetaController::class, 'index']);

/*
|--------------------------------------------------------------------------
| Users Routes
|--------------------------------------------------------------------------
| إدارة المستخدمين
*/
Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index']);         // كل المستخدمين
});

/*
|--------------------------------------------------------------------------
| Reviews Routes
|--------------------------------------------------------------------------
| إدارة التقييمات
*/
Route::get('reviews', [ReviewController::class, 'index']);     // كل التقييمات
