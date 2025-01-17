<?php

use Illuminate\Support\Facades\Route;

Route::prefix(config('callmeaf-base.api.prefix_url'))->as(config('callmeaf-base.api.prefix_route_name'))->middleware(config('callmeaf-base.api.middlewares'))->group(function() {
    Route::as('auth.')->group(function() {
        // Register
        Route::controller(config('callmeaf-auth.controllers.register'))->group(function() {
            Route::post('/register','register')->name('register');
            Route::post('/register_via_mobile','registerViaMobile')->name('register_via_mobile');
            Route::post('/register_via_email','registerViaEmail')->name('register_via_email');
        });
        // Login
        Route::controller(config('callmeaf-auth.controllers.login'))->group(function() {
            Route::post('/login_via_email', 'loginViaEmail')->name('login_via_email');
            Route::post('/login_via_mobile', 'loginViaMobile')->name('login_via_mobile');
            Route::post('/login_via_otp', 'loginViaOtp')->name('login_via_otp');
        });
        // Auth User
        Route::controller(config('callmeaf-auth.controllers.auth'))->group(function() {
            Route::get('/check_user','checkUser')->name('check_user');
            Route::get('/user','userShow')->name('user_show');
            Route::patch('/user','userUpdate')->name('user_update');
            Route::post('/password','passwordStore')->name('password_store');
            Route::patch('/password','passwordUpdate')->name('password_update');
            Route::patch('/profile_image','profileImageUpdate')->name('profile_image_update');
            Route::delete('/logout','logout')->name('logout');
        });
        // Forgot Password
        Route::controller(config('callmeaf-password.controllers.forgot_password'))->group(function () {
            Route::post('/forgot_password','forgotPassword')->name('forgot_password');
            Route::patch('/update_password','updatePassword')->name('update_password');
        });
    });
});
