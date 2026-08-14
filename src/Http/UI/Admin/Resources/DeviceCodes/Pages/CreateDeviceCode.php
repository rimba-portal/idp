<?php

declare(strict_types=1);

namespace Rimba\Http\UI\Admin\Resources\DeviceCodes\Pages;

use Filament\Resources\Pages\CreateRecord;
use Rimba\Http\UI\Admin\Resources\DeviceCodes\DeviceCodeResource;

class CreateDeviceCode extends CreateRecord
{
    protected static string $resource = DeviceCodeResource::class;
}
