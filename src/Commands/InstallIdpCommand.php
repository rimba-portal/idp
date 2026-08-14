<?php

declare(strict_types=1);

namespace Rimba\Idp\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Laravel\Passport\ClientRepository;

#[Description('Install Passport and optionally create a sample OAuth client for testing.')]
#[Signature('idp:install {--create-client}')]
class InstallIdpCommand extends Command
{
    public function handle(): void
    {
        $this->info('Running migrations...');
        $this->call('migrate');

        $this->info('Installing Passport keys...');
        $this->call('passport:install');

        if ($this->option('create-client')) {
            $clientRepository = new ClientRepository;
            $client = $clientRepository->createAuthCodeClient(null, 'sample-client', 'http://localhost:8001/callback');
            $this->info('Created client: ID='.$client->id.' Secret='.$client->secret);
        }

        $this->info('IdP install complete.');
    }
}
