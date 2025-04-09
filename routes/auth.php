<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    // Show registration form
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    // Handle user registration
    Route::post('register', [RegisteredUserController::class, 'store']);

    // Show login form
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    // Handle login request
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // Show forgot password form
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    // Send password reset link to email
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    // Show reset password form with token
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    // Handle password reset submission
    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    // Prompt user to verify email
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    // Verify email using ID and hash
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    // Resend verification email
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    // Show confirm password form (for sensitive actions)
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    // Handle confirm password submission
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    // Update user password
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    // Logout the user
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
