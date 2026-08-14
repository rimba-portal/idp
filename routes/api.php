<?php

use Illuminate\Support\Facades\Route;
use Rimba\Idp\Http\API\Controllers\UserInfoController;

Route::middleware(config('idp.routes.api_middleware', ['api', 'auth:api']))
    ->prefix(config('idp.routes.prefix', 'idp'))
    ->group(function (): void {
        Route::get('/userinfo', UserInfoController::class)->name('idp.userinfo');
    });
