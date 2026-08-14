<?php

declare(strict_types=1);

namespace Rimba\Http\UI\Admin\Resources\AuthCodes\Pages;

use Filament\Resources\Pages\CreateRecord;
use Rimba\Http\UI\Admin\Resources\AuthCodes\AuthCodeResource;

class CreateAuthCode extends CreateRecord
{
    protected static string $resource = AuthCodeResource::class;
}
