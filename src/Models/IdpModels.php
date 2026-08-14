<?php

declare(strict_types=1);

namespace Rimba\Idp\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Rimba\Idp\Enums\ClientApplicationType;
use Rimba\Idp\Enums\ClientStatus;
use Rimba\Idp\Enums\ClientTrustLevel;

class IdpClient extends Model
{
    protected $guarded = [];

    public function claims(): HasMany
    {
        return $this->hasMany(IdpClientClaim::class);
    }

    public function consents(): HasMany
    {
        return $this->hasMany(IdpConsent::class);
    }

    protected function casts(): array
    {
        return [
            'application_type' => ClientApplicationType::class,
            'trust_level' => ClientTrustLevel::class,
            'status' => ClientStatus::class,
            'allowed_scopes' => 'array',
            'redirect_uris' => 'array',
            'post_logout_redirect_uris' => 'array',
            'secret_rotated_at' => 'datetime',
            'last_used_at' => 'datetime',
        ];
    }
}

class IdpClientClaim extends Model
{
    protected $guarded = [];

    public function client(): BelongsTo
    {
        return $this->belongsTo(IdpClient::class, 'idp_client_id');
    }

    protected function casts(): array
    {
        return ['required' => 'boolean', 'enabled' => 'boolean', 'transform' => 'array'];
    }
}

class IdpConsent extends Model
{
    protected $guarded = [];

    public function client(): BelongsTo
    {
        return $this->belongsTo(IdpClient::class, 'idp_client_id');
    }

    protected function casts(): array
    {
        return ['scopes' => 'array', 'granted_at' => 'datetime', 'expires_at' => 'datetime', 'revoked_at' => 'datetime'];
    }
}

class IdpSecurityEvent extends Model
{
    protected $guarded = [];

    public function client(): BelongsTo
    {
        return $this->belongsTo(IdpClient::class, 'idp_client_id');
    }

    protected function casts(): array
    {
        return ['context' => 'array', 'occurred_at' => 'datetime'];
    }
}
