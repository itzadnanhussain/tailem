<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\LoginController;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Route;

Route::get('/sign-up',[LoginController::class,'LoadSignUpPage'])->middleware('auth')->name('sign-up'); 

Route::post('/sign-up', [LoginController::class, 'RegisterUser'])
    ->name('sign-up.RegisterUser'); 

Route::get('/sign-in', [LoginController::class, 'LoadSignInPage'])->middleware('auth')->name('sign-in');

Route::post('/sign-in', [LoginController::class, 'LoginUser'])
    ->name('sign-in.LoginUser');

// Route::post('/sign-in', [AuthenticatedSessionController::class, 'store'])
//                 ->middleware('guest');

Route::get('/forgot-password', [LoginController::class, 'ForgotPassword']);
               

// Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
//                 ->middleware('guest')
//                 ->name('password.email');

// Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
//                 ->middleware('guest')
//                 ->name('password.reset');

// Route::post('/reset-password', [NewPasswordController::class, 'store'])
//                 ->middleware('guest')
//                 ->name('password.update');

// Route::get('/verify-email', [EmailVerificationPromptController::class, '__invoke'])
//                 ->middleware('auth')
//                 ->name('verification.notice');

// Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
//                 ->middleware(['auth', 'signed', 'throttle:6,1'])
//                 ->name('verification.verify');

// Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
//                 ->middleware(['auth', 'throttle:6,1'])
//                 ->name('verification.send');

// Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])
//                 ->middleware('auth')
//                 ->name('password.confirm');

// Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store'])
//                 ->middleware('auth');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    // ->middleware('auth')
    ->name('logout');
