<?php

use Illuminate\Support\Facades\Route;

Route::prefix(config('callmeaf-base.api.prefix_url'))->as(config('callmeaf-base.api.prefix_route_name'))->middleware(config('callmeaf-base.api.middlewares'))->group(function() {
    Route::middleware(config('callmeaf-auth.middlewares.global'))->group(function() {
        Route::controller(config('callmeaf-auth.controllers.register'))->middleware(config('callmeaf-auth.middlewares.register'))->group(function() {
            Route::post('/register','register');
            Route::post('/register_via_mobile','registerViaMobile');
            Route::post('/register_via_email','registerViaEmail');
        });
        Route::controller(config('callmeaf-auth.controllers.login'))->middleware(config('callmeaf-auth.middlewares.login'))->group(function() {
            Route::post('/login_via_email', 'loginViaEmail');
            Route::post('/login_via_mobile', 'loginViaMobile');
            Route::post('/login_via_otp', 'loginViaOtp');
        });
        Route::controller(config('callmeaf-auth.controllers.auth'))->middleware(config('callmeaf-auth.middlewares.auth'))->group(function() {
            Route::get('/user','getUser');
            Route::patch('/user','updateUser');
            Route::post('/password','storePassword');
            Route::patch('/password','updatePassword');
            Route::patch('/profile_image','profileImage');
            Route::delete('/logout','logout');
        });
    });
    Route::middleware(config('callmeaf-password.middlewares.global'))->controller(config('callmeaf-password.controllers.forgot_password'))->group(function () {
        Route::post('/forgot_password','forgotPassword')->middleware(config('callmeaf-password.middlewares.forgot-password'));
        Route::patch('/update_password','updatePassword')->middleware(config('callmeaf-password.middlewares.update-password'));
    });
});
