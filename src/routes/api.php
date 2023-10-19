<?php

use Af\Auth\Http\Controllers\V1\RegisterController;
use Illuminate\Support\Facades\Route;

Route::prefix('api/af/v1')->group(function() {
    Route::post('register',[RegisterController::class,'register']);
});
