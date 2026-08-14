<?php

declare(strict_types=1);

namespace Rimba\Idp;

use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Event;
use Laravel\Passport\Console\ClientCommand;
use Laravel\Passport\Passport;
use Rimba\Base\Services\BitesServiceProvider;
use Rimba\Idp\Listeners\RevokePassportTokensOnLogout;

class IdpServiceProvider extends BitesServiceProvider
{
    protected string $viewsPath = __DIR__.'/../resources/views';

    protected function bootPackage(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // If you load keys from a custom directory
        Passport::loadKeysFrom('/etc/laravel/passport');
        // Register the consent view (namespaced)
        // Passport::authorizationView('rimba::oauth.authorize');
        $this->commands([ClientCommand::class]);
        Passport::authorizationView(function ($parameters): Factory|View {
            return view('bites::oauth.authorize', $parameters);
        });
        Passport::tokensCan(['user:read' => 'Retrieve the user info']);
        Passport::defaultScopes(['user:read']);

    }

    protected function registerPackage(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/bites_idp.php', 'bites_idp');
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        Event::listen(Logout::class, [RevokePassportTokensOnLogout::class, 'handle']);
        // Default token TTLs, can be overridden by config
        // Passport::tokensExpireIn(now()->addMinutes(config('bit-es-idp-passport.access_token_minutes', 60)));
        // Passport::refreshTokensExpireIn(now()->addDays(config('bit-es-idp-passport.refresh_token_days', 30)));
        Passport::tokensCan([
            'profile' => 'Read user profile',
            'email' => 'Read user email address',
            'roles' => 'Read user roles',
        ]);
        Passport::DefaultScopes(['profile']);

    }
}
