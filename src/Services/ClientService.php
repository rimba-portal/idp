<?php

declare(strict_types=1);

namespace Rimba\Idp\Services;

use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Client;
use Rimba\Idp\Models\IdpClient;
use RuntimeException;

class ClientService
{
    public function create(array $data): array
    {
        $arguments = [
            '--name' => $data['name'],
            '--redirect_uri' => implode(',', $data['redirect_uris']),
            '--no-interaction' => true,
        ];

        if (($data['public'] ?? false) === true) {
            $arguments['--public'] = true;
        }

        $exitCode = Artisan::call('passport:client', $arguments);
        if ($exitCode !== 0) {
            throw new RuntimeException(trim(Artisan::output()) ?: 'Passport client creation failed.');
        }

        $passportClient = Client::query()->latest('created_at')->firstOrFail();

        $idpClient = IdpClient::query()->create([
            'passport_client_id' => (string) $passportClient->getKey(),
            'code' => $data['code'],
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'redirect_uris' => $data['redirect_uris'],
            'allowed_scopes' => $data['allowed_scopes'] ?? ['profile'],
            'allow_users_api' => $data['allow_users_api'] ?? false,
            'allow_roles_api' => $data['allow_roles_api'] ?? false,
            'allow_permissions_api' => $data['allow_permissions_api'] ?? false,
            'active' => true,
        ]);

        return [
            'client' => $idpClient,
            'passport_client' => $passportClient,
            'command_output' => trim(Artisan::output()),
        ];
    }
}
