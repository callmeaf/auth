<?php

use Illuminate\Support\Facades\Route;

Route::prefix(config('callmeaf-base.prefix_api'))->middleware(config('callmeaf-auth.middlewares.global'))->group(function() {
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
    });
});
