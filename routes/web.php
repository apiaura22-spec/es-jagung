<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\OrderController as UserOrderController; 
use App\Http\Controllers\User\ReviewController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController; 
use App\Http\Controllers\Admin\PelangganController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ExpenseController; 
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\User\MidtransController;
use App\Models\Review;
use App\Models\Produk;

/*
|--------------------------------------------------------------------------
| PUBLIC ACCESS
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $reviews = Review::with('user')->latest()->take(6)->get();
    $avgRating   = round(Review::avg('rating'), 1);
    $totalReview = Review::count();
    $products = Produk::all(); 

    return view('welcome', compact('reviews', 'avgRating', 'totalReview', 'products'));
})->name('home');

Route::get('/produk/{id}', [UserDashboardController::class, 'show'])->name('public.produk.detail');


/*
|--------------------------------------------------------------------------
| ROUTE USER / PELANGGAN (WAJIB LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('user')->as('user.')->group(function () {

    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/produk-view/{id}', [UserDashboardController::class, 'show'])->name('produk.detail');

    // Keranjang & Checkout
    Route::prefix('cart')->as('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add/{id}', [CartController::class, 'add'])->name('add');
        Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('remove');
        Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
        Route::get('/checkout', [CartController::class, 'checkoutPage'])->name('checkout.show');
        Route::post('/checkout', [CartController::class, 'processCheckout'])->name('checkout.process');
        Route::get('/order/{id}', [CartController::class, 'showOrder'])->name('show_order');
        Route::get('/checkout/qr/{id}', [CartController::class, 'showCheckoutQR'])->name('checkout.qr');
        Route::post('/orders/upload/{id}', [CartController::class, 'uploadPaymentProof'])->name('upload.proof');
    });

    // Pesanan & Review
    Route::get('/orders', [UserOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [CartController::class, 'showOrder'])->name('orders.detail');
    Route::post('/review/{order}', [ReviewController::class, 'store'])->name('review.store');

    // Profil Pelanggan
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    Route::get('/pay/{order}', [MidtransController::class, 'pay'])->name('midtrans.pay');
});

/*
|--------------------------------------------------------------------------
| ROUTE ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('produk', ProdukController::class);
    
    // Manajemen Pesanan
    Route::prefix('pesanan')->as('pesanan.')->group(function () {
        Route::get('/', [AdminOrderController::class, 'index'])->name('index');
        Route::get('/{id}', [AdminOrderController::class, 'detail'])->name('detail');
        Route::post('/{id}/confirm', [AdminOrderController::class, 'confirm'])->name('confirm');
        Route::post('/{id}/reject', [AdminOrderController::class, 'reject'])->name('reject');
        Route::post('/{id}/process', [AdminOrderController::class, 'process'])->name('process');
        Route::post('/{id}/ready', [AdminOrderController::class, 'ready'])->name('ready');
        Route::post('/{id}/done', [AdminOrderController::class, 'done'])->name('done');
    });

    Route::get('/pelanggan', [PelangganController::class, 'index'])->name('pelanggan.index');
    
    // Laporan & Pengeluaran
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/pdf', [LaporanController::class, 'pdf'])->name('laporan.pdf');
    Route::post('/expense/store', [ExpenseController::class, 'store'])->name('expense.store');
    Route::delete('/expense/{id}', [ExpenseController::class, 'destroy'])->name('expense.destroy');

    // Profil Admin (DIPERBAIKI & DILENGKAPI)
    Route::get('/profile', [AdminProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/update', [AdminProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [AdminProfileController::class, 'updatePassword'])->name('profile.password.update');
});

/*
|--------------------------------------------------------------------------
| AUTHENTICATION
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->middleware('guest')->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->middleware('guest');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');

require __DIR__.'/auth.php';