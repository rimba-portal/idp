<?php

declare(strict_types=1);

namespace Rimba\Idp\Http\API\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Rimba\Idp\Contracts\UserInfoResolverContract;

class UserInfoController
{
    public function __invoke(Request $request, UserInfoResolverContract $resolver): JsonResponse
    {
        $token = $request->user()?->token();
        abort_unless($token, 401, 'Bearer token required.');

        return response()->json($resolver->resolve($request->user(), $token->scopes ?? []));
    }
}
