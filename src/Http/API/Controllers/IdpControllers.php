<?php

declare(strict_types=1);

namespace Rimba\Idp\Http\API\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Rimba\Idp\Models\IdpClient;
use Rimba\Idp\Services\ClaimResolverService;
use Rimba\Idp\Services\DiscoveryService;
use Rimba\Idp\Services\JwksService;

class DiscoveryController
{
    public function __invoke(DiscoveryService $service): JsonResponse
    {
        return response()->json($service->document());
    }
}

class JwksController
{
    public function __invoke(JwksService $service): JsonResponse
    {
        return response()->json($service->keys());
    }
}

class UserInfoController
{
    public function __invoke(Request $request, ClaimResolverService $claims): JsonResponse
    {
        $token = $request->user()?->token();
        abort_unless($token, 401, 'Bearer access token required.');
        $idpClient = IdpClient::query()->where('passport_client_id', (string) $token->client_id)->where('status', 'active')->firstOrFail();

        return response()->json($claims->resolve($request->user(), $idpClient, $token->scopes ?? []));
    }
}

class HealthController
{
    public function __invoke(): JsonResponse
    {
        return response()->json(['status' => 'ok', 'issuer' => config('idp.issuer'), 'oidc_complete' => false]);
    }
}
