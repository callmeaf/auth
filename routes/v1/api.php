<?php

use Illuminate\Support\Facades\Route;

/**
 * @var $registerController class-string<\Callmeaf\Auth\Http\Controllers\V1\Api\RegisterController>
 */
$registerController = config('callmeaf-auth.controllers.register');

Route::prefix('api/af/v1')->middleware(config('callmeaf-auth.middlewares.global'))->group(function() use ($registerController) {
    Route::controller($registerController)->group(function() {
        Route::post('/register','register');
        Route::post('/register_via_mobile','registerViaMobile');
        Route::post('/register_via_email','registerViaEmail');
    });
    Route::controller(config('callmeaf-auth.controllers.login'))->group(function() {
        Route::post('/login_via_email', 'loginViaEmail');
        Route::post('/login_via_mobile', 'loginViaMobile');
    });
});
