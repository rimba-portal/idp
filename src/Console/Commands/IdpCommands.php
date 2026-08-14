<?php

declare(strict_types=1);

namespace Rimba\Idp\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

#[Description('Validate the Rimba IdP OAuth2 foundation configuration.')]
#[Signature('idp:diagnose')]
class DiagnoseIdp extends Command
{
    public function handle(): int
    {
        $path = config('idp.passport_key_path');
        $public = $path ? rtrim($path, '/').'/oauth-public.key' : storage_path('oauth-public.key');
        $private = $path ? rtrim($path, '/').'/oauth-private.key' : storage_path('oauth-private.key');
        $checks = [
            'issuer configured' => filled(config('idp.issuer')),
            'public key exists' => File::exists($public),
            'private key exists' => File::exists($private),
            'OIDC intentionally disabled until ID-token extension' => config('idp.oidc.enabled') === false,
        ];
        foreach ($checks as $label => $ok) {
            $this->{$ok ? 'info' : 'error'}(($ok ? '[OK] ' : '[FAIL] ').$label);
        }

        return in_array(false, $checks, true) ? self::FAILURE : self::SUCCESS;
    }
}
