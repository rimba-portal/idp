<?php

declare(strict_types=1);
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return [
    'issuer' => env('IDP_ISSUER', env('APP_URL')),
    'passport_key_path' => env('IDP_PASSPORT_KEY_PATH'),
    'access_token_minutes' => (int) env('IDP_ACCESS_TOKEN_MINUTES', 60),
    'refresh_token_days' => (int) env('IDP_REFRESH_TOKEN_DAYS', 30),
    'personal_access_token_months' => (int) env('IDP_PERSONAL_TOKEN_MONTHS', 6),

    'scopes' => [
        'profile' => 'Read the signed-in user profile',
        'roles' => 'Read the signed-in user roles',
        'permissions' => 'Read the signed-in user permissions',
        'users.read' => 'Read the user directory',
        'roles.read' => 'Read the role directory',
        'permissions.read' => 'Read the permission directory',
    ],
    'default_scopes' => ['profile'],

    'models' => [
        'user' => env('IDP_USER_MODEL', User::class),
        'role' => env('IDP_ROLE_MODEL', Role::class),
        'permission' => env('IDP_PERMISSION_MODEL', Permission::class),
    ],

    'staff_relation' => 'staff',
    'staff_number_column' => 'staff_no',
    'auth_identifier_column' => 'auth_identifier',
];
