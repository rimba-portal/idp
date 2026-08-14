<?php

declare(strict_types=1);

namespace Rimba\Http\UI\Admin\Resources\RefreshTokens\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Rimba\Http\UI\Admin\Resources\RefreshTokens\RefreshTokenResource;

class ListRefreshTokens extends ListRecords
{
    protected static string $resource = RefreshTokenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
