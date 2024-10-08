<?php


Route::prefix(config('callmeaf-base.web.prefix_url'))->as(config('callmeaf-base.web.prefix_route_name'))->middleware(config('callmeaf-base.api.middlewares'))->group(function() {
    Route::controller(config('callmeaf-auth.controllers.auth_web'))->group(function() {
        Route::get('/email/verify/{id}/{hash}','verifyEmail')->name('verification.verify');
    });
});
