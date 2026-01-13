<?php

use Illuminate\Support\Facades\Route;

// Controller Auth
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;

// Controller User Order
use App\Http\Controllers\UserOrderController;

// Controller Admin Order (KOREKSI)
use App\Http\Controllers\Admin\OrderController;

// =========================
// ROUTE UNTUK GUEST
// =========================
Route::middleware('guest')->group(function () {

    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});

// =========================
// ROUTE UNTUK USER LOGIN
// =========================
Route::middleware('auth')->group(function () {

    // Email verification
    Route::get('verify-email', EmailVerificationPromptController::class)->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    // Password confirmation
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    // Update password
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    // Logout
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // ============================================================
    // USER ORDER ROUTES
    // ============================================================
    Route::get('/orders', [UserOrderController::class, 'index'])->name('user.orders');
    Route::get('/orders/{id}', [UserOrderController::class, 'detail'])->name('user.order.detail');
    Route::post('/orders/{id}/upload-payment', [UserOrderController::class, 'uploadPaymentProof'])
        ->name('user.order.uploadPayment');
});

// ============================================================
// ADMIN ORDER ROUTES
// ============================================================
Route::prefix('admin')->middleware('auth')->group(function () {

    // List pesanan admin
    Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders');

    // Detail pesanan admin
    Route::get('/orders/{id}', [OrderController::class, 'detail'])->name('admin.order.detail');

    // Konfirmasi pembayaran
    Route::post('/orders/{id}/confirm', [OrderController::class, 'confirm'])->name('admin.order.confirm');

    // Tolak pembayaran
    Route::post('/orders/{id}/reject', [OrderController::class, 'reject'])->name('admin.order.reject');
});
