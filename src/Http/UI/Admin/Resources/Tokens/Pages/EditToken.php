<?php

declare(strict_types=1);

namespace Rimba\Http\UI\Admin\Resources\Tokens\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Rimba\Http\UI\Admin\Resources\Tokens\TokenResource;

class EditToken extends EditRecord
{
    protected static string $resource = TokenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
