<?php

declare(strict_types=1);

namespace Rimba\Http\UI\Admin\Resources\AuthCodes\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Rimba\Http\UI\Admin\Resources\AuthCodes\AuthCodeResource;

class EditAuthCode extends EditRecord
{
    protected static string $resource = AuthCodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
