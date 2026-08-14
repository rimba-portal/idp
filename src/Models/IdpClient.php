<?php

declare(strict_types=1);

namespace Rimba\Idp\Models;

use Illuminate\Database\Eloquent\Model;

class IdpClient extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'redirect_uris' => 'array',
            'allowed_scopes' => 'array',
            'allow_users_api' => 'boolean',
            'allow_roles_api' => 'boolean',
            'allow_permissions_api' => 'boolean',
            'active' => 'boolean',
        ];
    }
}
