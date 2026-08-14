<?php

declare(strict_types=1);

return [
    'issuer' => env('IDP_ISSUER', env('APP_URL')),
    'passport_key_path' => env('IDP_PASSPORT_KEY_PATH'),
    'guard' => env('IDP_GUARD', 'api'),
    'access_token_minutes' => (int) env('IDP_ACCESS_TOKEN_MINUTES', 60),
    'refresh_token_days' => (int) env('IDP_REFRESH_TOKEN_DAYS', 30),
    'personal_access_token_months' => (int) env('IDP_PERSONAL_TOKEN_MONTHS', 6),
    'consent_ttl_days' => (int) env('IDP_CONSENT_TTL_DAYS', 365),
    'scopes' => [
        'profile' => 'Read basic profile information',
        'email' => 'Read email address',
        'staff' => 'Read staff identifier',
        'roles' => 'Read assigned roles',
        'permissions' => 'Read effective permissions',
        'attributes' => 'Read client-approved attributes',
    ],
    'default_scopes' => ['profile'],
    'claim_paths' => [
        'staff_relation' => 'staff',
        'staff_number' => 'staff_no',
        'attributes' => 'attributes',
    ],
    'routes' => [
        'prefix' => 'idp',
        'middleware' => ['web'],
        'api_middleware' => ['api', 'auth:api'],
    ],
    'oidc' => [
        // Passport is OAuth2. Keep false until an ID-token grant extension is installed and tested.
        'enabled' => (bool) env('IDP_OIDC_ENABLED', false),
        'id_token_signer' => env('IDP_ID_TOKEN_SIGNER'),
    ],
];
