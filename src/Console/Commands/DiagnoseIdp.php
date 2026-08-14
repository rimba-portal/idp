<?php

declare(strict_types=1);

namespace Rimba\Idp\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

#[Description('Check the simple Rimba IdP configuration.')]
#[Signature('idp:diagnose')]
class DiagnoseIdp extends Command
{
    public function handle(): int
    {
        $path = config('bites_idp.passport_key_path');
        $public = $path ? rtrim($path, '/').'/oauth-public.key' : storage_path('oauth-public.key');
        $private = $path ? rtrim($path, '/').'/oauth-private.key' : storage_path('oauth-private.key');
        $checks = [
            'Issuer configured' => filled(config('bites_idp.issuer')),
            'Passport public key exists' => File::exists($public),
            'Passport private key exists' => File::exists($private),
            'User model exists' => class_exists(config('bites_idp.models.user')),
            'Role model exists' => class_exists(config('bites_idp.models.role')),
            'Permission model exists' => class_exists(config('bites_idp.models.permission')),
        ];
        foreach ($checks as $name => $ok) {
            $this->{$ok ? 'info' : 'error'}(($ok ? '[OK] ' : '[FAIL] ').$name);
        }

        return in_array(false, $checks, true) ? self::FAILURE : self::SUCCESS;
    }
}
