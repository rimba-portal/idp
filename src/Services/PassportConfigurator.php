<?php

declare(strict_types=1);

namespace Rimba\Idp\Services;

use Laravel\Passport\Passport;

class PassportConfigurator
{
    public function boot(): void
    {
        if ($path = config('bites_idp.passport_key_path')) {
            Passport::loadKeysFrom($path);
        }

        Passport::tokensExpireIn(now()->addMinutes((int) config('bites_idp.access_token_minutes', 60)));
        Passport::refreshTokensExpireIn(now()->addDays((int) config('bites_idp.refresh_token_days', 30)));
        Passport::personalAccessTokensExpireIn(now()->addMonths((int) config('bites_idp.personal_access_token_months', 6)));
        Passport::tokensCan((array) config('bites_idp.scopes', []));
        Passport::defaultScopes((array) config('bites_idp.default_scopes', ['profile']));
        Passport::authorizationView('rimba-idp::oauth.authorize');
    }
}
