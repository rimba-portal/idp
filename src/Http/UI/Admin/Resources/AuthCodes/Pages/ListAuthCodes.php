<?php

declare(strict_types=1);

namespace Rimba\Http\UI\Admin\Resources\AuthCodes\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Rimba\Http\UI\Admin\Resources\AuthCodes\AuthCodeResource;

class ListAuthCodes extends ListRecords
{
    protected static string $resource = AuthCodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
