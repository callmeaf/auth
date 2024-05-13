<?php

use Illuminate\Support\Facades\Route;

Route::prefix(config('callmeaf-base.api.prefix_url'))->as(config('callmeaf-base.api.prefix_route_name'))->middleware(config('callmeaf-base.api.middlewares'))->group(function() {
    Route::controller(config('callmeaf-auth.controllers.register'))->group(function() {
        Route::post('/register','register')->name('auth.register');
        Route::post('/register_via_mobile','registerViaMobile')->name('auth.register_via_mobile');
        Route::post('/register_via_email','registerViaEmail')->name('auth.register_via_email');
    });
    Route::controller(config('callmeaf-auth.controllers.login'))->group(function() {
        Route::post('/login_via_email', 'loginViaEmail')->name('auth.login_via_email');
        Route::post('/login_via_mobile', 'loginViaMobile')->name('auth.login_via_mobile');
        Route::post('/login_via_otp', 'loginViaOtp')->name('auth.login_via_otp');
    });
    Route::controller(config('callmeaf-auth.controllers.auth'))->group(function() {
        Route::get('/user','userShow')->name('auth.user_show');
        Route::patch('/user','userUpdate')->name('auth.user_update');
        Route::post('/password','passwordStore')->name('auth.password_store');
        Route::patch('/password','passwordUpdate')->name('auth.password_update');
        Route::patch('/profile_image','profileImageUpdate')->name('auth.profile_image_update');
        Route::delete('/logout','logout')->name('auth.logout');
    });
    Route::controller(config('callmeaf-password.controllers.forgot_password'))->group(function () {
        Route::post('/forgot_password','forgotPassword')->name('auth.forgot_password');
        Route::patch('/update_password','updatePassword')->name('auth.update_password');
    });
});
