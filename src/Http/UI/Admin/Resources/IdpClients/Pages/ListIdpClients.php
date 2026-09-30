<?php

declare(strict_types=1);

namespace Rimba\Idp\Http\UI\Admin\Resources\IdpClients\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Rimba\Idp\Http\UI\Admin\Resources\IdpClients\IdpClientResource;

class ListIdpClients extends ListRecords
{
    protected static string $resource = IdpClientResource::class;

    protected static ?string $title = 'Identity Provider Clients';

    protected ?string $subheading = 'Connect external OAuth applications and manage secure API endpoints.';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
