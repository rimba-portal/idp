<?php

use Illuminate\Support\Facades\Route;
use Rimba\Idp\Http\API\Controllers\DiscoveryController;
use Rimba\Idp\Http\API\Controllers\HealthController;
use Rimba\Idp\Http\API\Controllers\JwksController;

Route::get('/.well-known/openid-configuration', DiscoveryController::class)->name('idp.discovery');
Route::prefix(config('idp.routes.prefix', 'idp'))->group(function (): void {
    Route::get('/jwks', JwksController::class)->name('idp.jwks');
    Route::get('/health', HealthController::class)->name('idp.health');
});
