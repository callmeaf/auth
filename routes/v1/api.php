<?php

use Callmeaf\Auth\Http\Controllers\Api\V1\RegisterController;
use Illuminate\Support\Facades\Route;

Route::prefix('api/af/v1')->group(function() {
    Route::post('register',[RegisterController::class,'register']);
    Route::post('/register_via_mobile',[RegisterController::class,'registerViaMobile']);
});
