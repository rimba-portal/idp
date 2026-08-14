<?php

declare(strict_types=1);

namespace Rimba\Idp\Actions;

use Laravel\Passport\ClientRepository;
use Rimba\Idp\Enums\ClientApplicationType;
use Rimba\Idp\Enums\ClientStatus;
use Rimba\Idp\Enums\ClientTrustLevel;
use Rimba\Idp\Models\IdpClient;
use Rimba\Idp\Models\IdpConsent;

class RegisterClient
{
    public function __construct(private ClientRepository $clientRepository) {}

    public function handle(array $data): array
    {
        $clientApplicationType = ClientApplicationType::from($data['application_type']);
        $redirects = $data['redirect_uris'];
        $passport = match ($clientApplicationType) {
            ClientApplicationType::PublicPkce => $this->clientRepository->createAuthorizationCodeGrantClient($data['name'], $redirects, confidential: false),
            ClientApplicationType::ConfidentialWeb => $this->clientRepository->createAuthorizationCodeGrantClient($data['name'], $redirects, confidential: true),
            ClientApplicationType::Service => $this->clientRepository->createClientCredentialsGrantClient($data['name']),
            ClientApplicationType::Device => throw new \InvalidArgumentException('Create device clients with the installed Passport version command/repository API.'),
        };

        $idpClient = IdpClient::query()->create([
            'passport_client_id' => (string) $passport->getKey(),
            'code' => $data['code'], 'system_name' => $data['name'],
            'application_type' => $clientApplicationType, 'trust_level' => ClientTrustLevel::Standard,
            'status' => ClientStatus::Active, 'owner_team' => $data['owner_team'] ?? null,
            'owner_staff_no' => $data['owner_staff_no'] ?? null,
            'allowed_scopes' => $data['allowed_scopes'] ?? config('idp.default_scopes'),
            'redirect_uris' => $redirects,
        ]);

        return ['client' => $idpClient, 'passport_client' => $passport];
    }
}

class RevokeConsent
{
    public function handle(IdpConsent $consent): void
    {
        $consent->forceFill(['revoked_at' => now()])->save();
    }
}
