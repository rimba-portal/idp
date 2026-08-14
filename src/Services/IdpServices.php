<?php

declare(strict_types=1);

namespace Rimba\Idp\Services;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Rimba\Idp\Models\IdpClient;
use Rimba\Idp\Models\IdpSecurityEvent;

class ClaimResolverService
{
    public function resolve(Authenticatable $user, IdpClient $client, array $scopes): array
    {
        $staff = data_get($user, config('idp.claim_paths.staff_relation', 'staff'));
        $base = [
            'sub' => (string) $user->getAuthIdentifier(),
            'name' => data_get($user, 'name'),
            'email' => in_array('email', $scopes, true) ? data_get($user, 'email') : null,
            'preferred_username' => data_get($user, 'auth_identifier', data_get($user, 'email')),
            'staff_no' => in_array('staff', $scopes, true) ? data_get($staff, config('idp.claim_paths.staff_number', 'staff_no')) : null,
            'roles' => in_array('roles', $scopes, true) && $staff && method_exists($staff, 'getRoleNames') ? $staff->getRoleNames()->values()->all() : [],
            'permissions' => in_array('permissions', $scopes, true) && $staff && method_exists($staff, 'getAllPermissions') ? $staff->getAllPermissions()->pluck('name')->values()->all() : [],
        ];

        $source = ['user' => $user, 'staff' => $staff];
        foreach ($client->claims()->where('enabled', true)->get() as $claim) {
            if ($claim->scope && ! in_array($claim->scope, $scopes, true)) {
                continue;
            }

            $base[$claim->claim] = data_get($source, $claim->source_path);
        }

        return array_filter($base, static fn ($value): bool => $value !== null);
    }
}

class DiscoveryService
{
    public function document(): array
    {
        $issuer = rtrim((string) config('idp.issuer'), '/');

        return [
            'issuer' => $issuer,
            'authorization_endpoint' => $issuer.'/oauth/authorize',
            'token_endpoint' => $issuer.'/oauth/token',
            'userinfo_endpoint' => $issuer.'/idp/userinfo',
            'jwks_uri' => $issuer.'/idp/jwks',
            'response_types_supported' => ['code'],
            'grant_types_supported' => ['authorization_code', 'refresh_token', 'client_credentials'],
            'code_challenge_methods_supported' => ['S256'],
            'scopes_supported' => array_keys((array) config('idp.scopes', [])),
            'token_endpoint_auth_methods_supported' => ['client_secret_basic', 'client_secret_post', 'none'],
            'claims_supported' => ['sub', 'name', 'email', 'preferred_username', 'staff_no', 'roles', 'permissions', 'attributes'],
            'rimba_oidc_complete' => false,
        ];
    }
}

class JwksService
{
    public function keys(): array
    {
        return Cache::remember('rimba.idp.jwks', 3600, function (): array {
            $path = config('idp.passport_key_path');
            $public = $path ? rtrim($path, '/').'/oauth-public.key' : storage_path('oauth-public.key');
            if (! File::exists($public)) {
                return ['keys' => []];
            }

            $details = openssl_pkey_get_details(openssl_pkey_get_public(File::get($public)));
            if (! $details || ! isset($details['rsa'])) {
                return ['keys' => []];
            }

            $b64 = static fn (string $v): string => rtrim(strtr(base64_encode($v), '+/', '-_'), '=');

            return ['keys' => [[
                'kty' => 'RSA', 'use' => 'sig', 'alg' => 'RS256',
                'kid' => substr(hash('sha256', File::get($public)), 0, 16),
                'n' => $b64($details['rsa']['n']), 'e' => $b64($details['rsa']['e']),
            ]]];
        });
    }
}

class SecurityEventService
{
    public function record(string $type, string $result = 'success', ?IdpClient $client = null, ?Authenticatable $user = null, array $context = []): void
    {
        IdpSecurityEvent::query()->create([
            'idp_client_id' => $client?->getKey(), 'user_id' => $user ? (string) $user->getAuthIdentifier() : null,
            'event_type' => $type, 'result' => $result,
            'ip_address' => request()?->ip(), 'user_agent' => request()?->userAgent(),
            'context' => $context, 'occurred_at' => now(),
        ]);
    }
}
