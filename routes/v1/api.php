<?php

use Callmeaf\Auth\Http\Controllers\Api\V1\LoginController;
use Callmeaf\Auth\Http\Controllers\Api\V1\RegisterController;
use Illuminate\Support\Facades\Route;

Route::prefix('api/af/v1')->group(function() {
    Route::post('/register',[RegisterController::class,'register']);
    Route::post('/register_via_mobile',[RegisterController::class,'registerViaMobile']);
    Route::post('/register_via_email',[RegisterController::class,'registerViaEmail']);
    Route::post('/login_via_email',[LoginController::class,'loginViaEmail']);
});
