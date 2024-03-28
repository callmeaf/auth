<?php


Route::prefix(config('callmeaf-base.web.prefix_url'))->as(config('callmeaf-base.web.prefix_route_name'))->controller(config('callmeaf-auth.controllers.auth_web'))->group(function() {
    Route::get('/email/verify/{id}/{hash}','verifyEmail')->middleware(config('callmeaf-auth.middlewares.verify_email'))->name('verification.verify');
});
