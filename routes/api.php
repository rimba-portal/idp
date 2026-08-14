<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Rimba\Idp\Http\API\Controllers\PermissionsController;
use Rimba\Idp\Http\API\Controllers\RolesController;
use Rimba\Idp\Http\API\Controllers\UserInfoController;
use Rimba\Idp\Http\API\Controllers\UsersController;

Route::prefix('idp')->middleware(['api', 'auth:api'])->group(function (): void {
    Route::get('/user', UserInfoController::class)->name('idp.user');
    Route::get('/users', UsersController::class)->middleware('idp.client-api:users.read')->name('idp.users');
    Route::get('/roles', RolesController::class)->middleware('idp.client-api:roles.read')->name('idp.roles');
    Route::get('/permissions', PermissionsController::class)->middleware('idp.client-api:permissions.read')->name('idp.permissions');
});
