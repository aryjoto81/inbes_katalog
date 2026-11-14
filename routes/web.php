<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CarouselController;
use App\Http\Controllers\FrontProductController;


Route::get('/products', [FrontProductController::class, 'products'])->name('front.products');

/*
|--------------------------------------------------------------------------
| 1. RUTE AUTH & ADMIN (Diletakkan paling atas agar tidak tertutup wildcard)
|--------------------------------------------------------------------------
*/

// Halaman Login Admin
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Rute Admin Panel (Dilindungi middleware auth:admin)
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('admins', AdminController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('carousels', CarouselController::class)->except(['show']);
});


/*
|--------------------------------------------------------------------------
| 2. RUTE UTILITAS & TRACKING
|--------------------------------------------------------------------------
*/



// Tracking klik produk dan redirect ke link eksternal
Route::get('/product/visit/{id}', [FrontProductController::class, 'trackAndRedirect'])->name('front.product.visit');


/*
|--------------------------------------------------------------------------
| 3. RUTE PUBLIK FRONTEND (Wildcard /{linkid} diletakkan paling bawah)
|--------------------------------------------------------------------------
*/

Route::middleware(['web'])->group(function () {
    Route::get('/', [FrontProductController::class, 'index'])->name('front.home');
    Route::get('/products', [FrontProductController::class, 'products'])->name('front.products');
    Route::get('/about', [FrontProductController::class, 'about'])->name('front.about');
    Route::get('/contact', [FrontProductController::class, 'contact'])->name('front.contact');

    // PENTING: Wildcard /{linkid} harus berada di urutan PALING BAWAH
    Route::get('/{linkid}', [FrontProductController::class, 'show'])->name('front.product.detail');
});

Route::get('/check-storage', function () {
    $publicStorage = public_path('storage');
    return [
        'exists' => file_exists($publicStorage),
        'is_link' => is_link($publicStorage),
        'target' => is_link($publicStorage) ? readlink($publicStorage) : 'Bukan symlink',
    ];
});
