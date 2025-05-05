<?php

use Illuminate\Support\Facades\Route;

[
    $controllers,
    $prefix,
    $as,
    $middleware,
] = Base::getRouteConfigFromRepo(repo: \Callmeaf\Auth\App\Repo\Contracts\AuthRepoInterface::class);


Route::prefix($prefix)->as($as)->middleware($middleware)->controller($controllers['auth'])->group(function () {
    Route::post('/login', 'login');
    Route::post('/login_via_password','loginViaPassword');
    Route::get('/user', 'user');
    Route::post('/logout', 'logout');
    Route::patch('/profile','profileUpdate');
    Route::patch('/password','passwordUpdate');
    Route::patch('/accept_terms','acceptTerms');
});
