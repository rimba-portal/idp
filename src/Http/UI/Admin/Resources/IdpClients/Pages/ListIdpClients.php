<?php

namespace Rimba\Idp\Http\UI\Admin\Resources\IdpClients\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListIdpClients extends ListRecords
{
    protected static string $resource = \Rimba\Idp\Http\UI\Admin\Resources\IdpClients\IdpClientResource::class;

    protected static ?string $title = 'Identity Provider Clients';

    protected ?string $subheading = 'Connect external OAuth applications and manage secure API endpoints.';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
