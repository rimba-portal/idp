<?php

declare(strict_types=1);

namespace Rimba\Idp\Events;

use Illuminate\Foundation\Events\Dispatchable;

class ClientRegistered
{
    use Dispatchable;

    public function __construct(public readonly int $clientId) {}
}

class ConsentGranted
{
    use Dispatchable;

    public function __construct(public readonly int $consentId) {}
}

class ConsentRevoked
{
    use Dispatchable;

    public function __construct(public readonly int $consentId) {}
}
