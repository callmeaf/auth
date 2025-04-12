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
    Route::get('/user', 'user');
    Route::post('/logout', 'logout');
});
