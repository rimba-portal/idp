<?php

declare(strict_types=1);

namespace Rimba\Http\UI\Admin\Resources\RefreshTokens\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Rimba\Http\UI\Admin\Resources\RefreshTokens\RefreshTokenResource;

class EditRefreshToken extends EditRecord
{
    protected static string $resource = RefreshTokenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
