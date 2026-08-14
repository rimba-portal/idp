<?php

declare(strict_types=1);

namespace Rimba\Http\UI\Admin\Resources\DeviceCodes\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Rimba\Http\UI\Admin\Resources\DeviceCodes\DeviceCodeResource;

class ListDeviceCodes extends ListRecords
{
    protected static string $resource = DeviceCodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
