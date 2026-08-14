<?php

declare(strict_types=1);

namespace Rimba\Idp;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Events\AccessTokenCreated;
use Laravel\Passport\Passport;
use Rimba\Idp\Console\Commands\DiagnoseIdp;
use Rimba\Idp\Listeners\RecordAccessTokenIssued;

class IdpServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/idp.php', 'idp');
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'rimba-idp');

        if ($path = config('idp.passport_key_path')) {
            Passport::loadKeysFrom($path);
        }

        Passport::tokensExpireIn(now()->addMinutes((int) config('idp.access_token_minutes')));
        Passport::refreshTokensExpireIn(now()->addDays((int) config('idp.refresh_token_days')));
        Passport::personalAccessTokensExpireIn(now()->addMonths((int) config('idp.personal_access_token_months')));
        Passport::tokensCan((array) config('idp.scopes'));
        Passport::defaultScopes((array) config('idp.default_scopes'));

        Event::listen(AccessTokenCreated::class, RecordAccessTokenIssued::class);
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__.'/../config/idp.php' => config_path('idp.php')], 'rimba-idp-config');
            $this->publishes([__DIR__.'/../resources/views' => resource_path('views/vendor/rimba-idp')], 'rimba-idp-views');
            $this->commands([DiagnoseIdp::class]);
        }
    }
}
