<?php

declare(strict_types=1);

namespace Rimba\Idp\Services;

use Illuminate\Contracts\Auth\Authenticatable;
use Rimba\Idp\Contracts\UserInfoResolverContract;

class UserInfoService implements UserInfoResolverContract
{
    public function resolve(Authenticatable $user, array $scopes): array
    {
        $staff = data_get($user, (string) config('bites_idp.staff_relation', 'staff'));

        $payload = [
            'sub' => (string) $user->getAuthIdentifier(),
            'name' => data_get($user, 'name'),
            'email' => data_get($user, 'email'),
            'auth_identifier' => data_get($user, config('bites_idp.auth_identifier_column', 'auth_identifier')),
            'staff_no' => data_get($staff, config('bites_idp.staff_number_column', 'staff_no')),
        ];

        if (in_array('roles', $scopes, true)) {
            $payload['roles'] = $staff && method_exists($staff, 'getRoleNames')
                ? $staff->getRoleNames()->values()->all()
                : [];
        }

        if (in_array('permissions', $scopes, true)) {
            $payload['permissions'] = $staff && method_exists($staff, 'getAllPermissions')
                ? $staff->getAllPermissions()->pluck('name')->values()->all()
                : [];
        }

        return array_filter($payload, static fn (mixed $value): bool => $value !== null);
    }
}
