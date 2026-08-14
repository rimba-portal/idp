<?php

declare(strict_types=1);

namespace Rimba\Idp;

use Illuminate\Routing\Router;
use Rimba\Base\Services\BitesServiceProvider;
use Rimba\Idp\Contracts\UserInfoResolverContract;
use Rimba\Idp\Http\Middleware\EnsureClientApiAccess;
use Rimba\Idp\Services\PassportConfigurator;
use Rimba\Idp\Services\UserInfoService;

class IdpServiceProvider extends BitesServiceProvider
{
    protected string $configFile = __DIR__.'/../config/bites.php';

    protected string $viewsPath = __DIR__.'/../resources/views';

    protected string $iconsPath = __DIR__.'/../resources/svg';

    protected function bootPackage(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        app(PassportConfigurator::class)->boot();
        $this->app->make(Router::class)->aliasMiddleware('idp.client-api', EnsureClientApiAccess::class);

    }

    protected function registerPackage(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/bites_idp.php', 'bites_idp');
        $this->app->bind(UserInfoResolverContract::class, UserInfoService::class);

    }
}
