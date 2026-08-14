<?php

declare(strict_types=1);

namespace Rimba\Idp\Listeners;

use Laravel\Passport\Events\AccessTokenCreated;
use Rimba\Idp\Models\IdpClient;
use Rimba\Idp\Services\SecurityEventService;

class RecordAccessTokenIssued
{
    public function __construct(private SecurityEventService $securityEventService) {}

    public function handle(AccessTokenCreated $event): void
    {
        $client = IdpClient::query()->where('passport_client_id', (string) $event->clientId)->first();
        $this->securityEventService->record('TokenIssued', 'success', $client, null, ['token_id' => $event->tokenId]);
        $client?->forceFill(['last_used_at' => now()])->save();
    }
}
