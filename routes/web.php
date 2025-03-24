<?php

use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ResetPasswordController;


Route::get('/', [PostController::class, 'index']);


Route::middleware(['guest'])->group(function () {
    //Register
    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    //Login
    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    //reset password
    Route::view('/forgot-password', 'auth.forgot-password')->name('password.request');
    Route::post('/forgot-password', [ResetPasswordController::class,'passwordEmail']);
    
    Route::get('/reset-password/{token}', [ResetPasswordController::class,'passwordReset'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class,'passwordUpdate'])->name('password.update');
    
    
    
});

Route::middleware(['auth'])->group(function () {
    //Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    //dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->middleware('verified')->name('dashboard');
    // email verification notice
    Route::get('/email/verify', [AuthController::class, 'verifyNotice'])->name('verification.notice');

    //email  verification handle
    Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])->middleware('signed')->name('verification.verify');
    //resending the email verification
    Route::post('/email/verification-notification', [AuthController::class, 'verifyHandler'])->middleware('throttle:6,1')->name('verification.send');
});
//posts

Route::resource('posts', PostController::class);
Route::get('/{user}/posts', [DashboardController::class, 'userPosts'])->name('posts.user');


