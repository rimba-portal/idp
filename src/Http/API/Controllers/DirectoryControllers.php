<?php

declare(strict_types=1);

namespace Rimba\Idp\Http\API\Controllers;

use Illuminate\Http\JsonResponse;

class UsersController
{
    public function __invoke(): JsonResponse
    {
        $model = config('bites_idp.models.user');
        $users = $model::query()->with(config('bites_idp.staff_relation', 'staff'))->paginate(100);

        return response()->json($users->through(static function ($user): array {
            $staff = data_get($user, config('bites_idp.staff_relation', 'staff'));

            return [
                'sub' => (string) $user->getAuthIdentifier(),
                'name' => data_get($user, 'name'),
                'email' => data_get($user, 'email'),
                'auth_identifier' => data_get($user, config('bites_idp.auth_identifier_column', 'auth_identifier')),
                'staff_no' => data_get($staff, config('bites_idp.staff_number_column', 'staff_no')),
            ];
        }));
    }
}

class RolesController
{
    public function __invoke(): JsonResponse
    {
        $model = config('bites_idp.models.role');

        return response()->json($model::query()->select(['id', 'name', 'guard_name'])->orderBy('name')->paginate(100));
    }
}

class PermissionsController
{
    public function __invoke(): JsonResponse
    {
        $model = config('bites_idp.models.permission');

        return response()->json($model::query()->select(['id', 'name', 'guard_name'])->orderBy('name')->paginate(100));
    }
}
