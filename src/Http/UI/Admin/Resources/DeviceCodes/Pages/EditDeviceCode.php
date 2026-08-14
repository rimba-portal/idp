<?php

declare(strict_types=1);

namespace Rimba\Http\UI\Admin\Resources\DeviceCodes\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Rimba\Http\UI\Admin\Resources\DeviceCodes\DeviceCodeResource;

class EditDeviceCode extends EditRecord
{
    protected static string $resource = DeviceCodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
