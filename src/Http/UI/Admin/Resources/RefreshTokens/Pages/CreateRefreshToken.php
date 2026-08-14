<?php

declare(strict_types=1);

namespace Rimba\Http\UI\Admin\Resources\RefreshTokens\Pages;

use Filament\Resources\Pages\CreateRecord;
use Rimba\Http\UI\Admin\Resources\RefreshTokens\RefreshTokenResource;

class CreateRefreshToken extends CreateRecord
{
    protected static string $resource = RefreshTokenResource::class;
}
