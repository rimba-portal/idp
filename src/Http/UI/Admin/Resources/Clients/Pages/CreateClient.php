<?php

declare(strict_types=1);

namespace Rimba\Http\UI\Admin\Resources\Clients\Pages;

use Filament\Resources\Pages\CreateRecord;
use Rimba\Http\UI\Admin\Resources\Clients\ClientResource;

class CreateClient extends CreateRecord
{
    protected static string $resource = ClientResource::class;
}
