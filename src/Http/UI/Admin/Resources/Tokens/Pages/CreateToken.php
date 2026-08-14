<?php

declare(strict_types=1);

namespace Rimba\Http\UI\Admin\Resources\Tokens\Pages;

use Filament\Resources\Pages\CreateRecord;
use Rimba\Http\UI\Admin\Resources\Tokens\TokenResource;

class CreateToken extends CreateRecord
{
    protected static string $resource = TokenResource::class;
}
