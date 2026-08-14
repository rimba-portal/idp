<?php

declare(strict_types=1);

namespace Rimba\Idp\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Rimba\Idp\Models\IdpClient;
use Symfony\Component\HttpFoundation\Response;

class EnsureClientApiAccess
{
    public function handle(Request $request, Closure $next, string $ability): Response
    {
        $token = $request->user()?->token();
        abort_unless($token, 401, 'Bearer token required.');

        $client = IdpClient::query()
            ->where('passport_client_id', (string) $token->client_id)
            ->where('active', true)
            ->first();

        abort_unless($client, 403, 'Client is inactive or unregistered.');
        abort_unless($token->can($ability), 403, "Missing scope: {$ability}");

        $flag = match ($ability) {
            'users.read' => 'allow_users_api',
            'roles.read' => 'allow_roles_api',
            'permissions.read' => 'allow_permissions_api',
            default => null,
        };

        abort_unless($flag && $client->{$flag}, 403, 'This API is not enabled for the client.');
        $request->attributes->set('idp_client', $client);

        return $next($request);
    }
}
