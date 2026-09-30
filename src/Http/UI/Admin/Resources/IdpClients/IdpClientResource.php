<?php

declare(strict_types=1);

namespace Rimba\Idp\Http\UI\Admin\Resources\IdpClients;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Rimba\Idp\Http\UI\Admin\Resources\IdpClients\Pages\ListIdpClients;
use Rimba\Idp\Models\IdpClient;
use UnitEnum;

class IdpClientResource extends Resource
{
    protected static ?string $model = IdpClient::class;

    protected static string|UnitEnum|null $navigationGroup = 'Idp';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-key';

    protected static ?int $navigationSort = 96;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([]);
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
            'index' => ListIdpClients::route('/'),
            // 'create' => \Rimba\Idp\Http\UI\Admin\Resources\IdpClients\Pages\CreateIdpClient::route('/create'),
            // 'view' => \Rimba\Idp\Http\UI\Admin\Resources\IdpClients\Pages\ViewIdpClient::route('/{record}'),
            // 'edit' => \Rimba\Idp\Http\UI\Admin\Resources\IdpClients\Pages\EditIdpClient::route('/{record}/edit'),
            //
        ];
    }
}
