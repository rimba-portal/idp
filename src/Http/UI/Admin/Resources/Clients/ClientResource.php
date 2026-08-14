<?php

declare(strict_types=1);

namespace Rimba\Http\UI\Admin\Resources\Clients;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Laravel\Passport\Client;
use Rimba\Http\UI\Admin\Resources\Clients\Pages\CreateClient;
use Rimba\Http\UI\Admin\Resources\Clients\Pages\EditClient;
use Rimba\Http\UI\Admin\Resources\Clients\Pages\ListClients;
use Rimba\Http\UI\Admin\Resources\Clients\Schemas\ClientForm;
use Rimba\Http\UI\Admin\Resources\Clients\Tables\ClientsTable;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static string|BackedEnum|null $navigationIcon = 'bites-sw-app';

    protected static ?string $modelLabel = 'Client Apps';

    public static function form(Schema $schema): Schema
    {
        return ClientForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ClientsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListClients::route('/'),
            'create' => CreateClient::route('/create'),
            'edit' => EditClient::route('/{record}/edit'),
        ];
    }
}
