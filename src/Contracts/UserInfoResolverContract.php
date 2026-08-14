<?php

declare(strict_types=1);

namespace Rimba\Idp\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;

interface UserInfoResolverContract
{
    public function resolve(Authenticatable $user, array $scopes): array;
}
