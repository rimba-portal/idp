<?php

declare(strict_types=1);

namespace Rimba\Idp;

use Illuminate\Routing\Router;
use Rimba\Base\Services\BitesServiceProvider;
use Rimba\Idp\Console\Commands\DiagnoseIdp;
use Rimba\Idp\Contracts\UserInfoResolverContract;
use Rimba\Idp\Http\Middleware\EnsureClientApiAccess;
use Rimba\Idp\Services\PassportConfigurator;
use Rimba\Idp\Services\UserInfoService;

class IdpServiceProvider extends BitesServiceProvider
{
    protected string $configPath = __DIR__.'/../config/idp.php';

    protected string $viewsPath = __DIR__.'/../resources/views';

    protected array $commands = [DiagnoseIdp::class];

    protected function registerPackage(): void
    {
        $this->app->bind(UserInfoResolverContract::class, UserInfoService::class);
    }

    protected function bootPackage(): void
    {
        app(PassportConfigurator::class)->boot();
        $this->app->make(Router::class)->aliasMiddleware('idp.client-api', EnsureClientApiAccess::class);
    }
}
