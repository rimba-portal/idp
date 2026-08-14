<?php

declare(strict_types=1);

namespace Rimba\Http\UI\Admin\Resources\Users\Pages;

use Filament\Actions;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Rimba\Http\UI\Admin\Resources\Users\UserResource;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // DeleteAction::make(),

            Actions\Action::make('reset_mfa')
                ->label('Reset MFA Secret')
                ->color('danger')
                ->requiresConfirmation()
                ->icon('heroicon-o-shield-exclamation')
                ->action(function (): void {
                    $this->record->app_authentication_secret = null;
                    $this->record->save();

                    // $this->notify('success', 'MFA secret has been reset.');
                }),
        ];
    }
}
