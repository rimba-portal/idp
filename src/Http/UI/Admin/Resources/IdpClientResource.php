<?php

declare(strict_types=1);

namespace Rimba\Idp\Http\UI\Admin\Resources;

use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Rimba\Idp\Models\IdpClient;
use Rimba\Idp\Services\ClientService;

class IdpClientResource extends Resource
{
    protected static ?string $model = IdpClient::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-key';

    protected static ?string $modelLabel = 'IDP Client';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function table(Table $table): Table
    {

        return $table
            ->columns([
                TextColumn::make('code')->searchable()->copyable(),
                TextColumn::make('name')->searchable(),
                TextColumn::make('passport_client_id')->label('Client ID')->copyable(),
                TextColumn::make('allowed_scopes')->badge(),
                IconColumn::make('allow_users_api')->boolean()->label('Users API'),
                IconColumn::make('allow_roles_api')->boolean()->label('Roles API'),
                IconColumn::make('allow_permissions_api')->boolean()->label('Permissions API'),
                IconColumn::make('active')->boolean(),
            ]);
    }

    public static function getPages(): array
    {
        return ['index' => ListIdpClients::route('/')];
    }
}

class ListIdpClients extends ListRecords
{
    protected static string $resource = IdpClientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('registerClient')
                ->label('Register Client')
                ->icon('heroicon-o-plus')
                ->schema([
                    TextInput::make('code')->required()->unique('idp_clients', 'code'),
                    TextInput::make('name')->required(),
                    TextInput::make('description'),
                    Repeater::make('redirect_uris')
                        ->simple(TextInput::make('url')->url()->required())
                        ->minItems(1)->required(),
                    CheckboxList::make('allowed_scopes')
                        ->options(config('bites_idp.scopes'))->default(config('bites_idp.default_scopes')),
                    Toggle::make('public')->helperText('Enable for browser/SPA clients using PKCE.'),
                    Toggle::make('allow_users_api'),
                    Toggle::make('allow_roles_api'),
                    Toggle::make('allow_permissions_api'),
                ])
                ->action(function (array $data, ClientService $service): void {
                    $result = $service->create($data);
                    Notification::make()
                        ->success()
                        ->title('Client registered')
                        ->body("Client ID: {$result['client']->passport_client_id}\n\n{$result['command_output']}")
                        ->persistent()
                        ->send();
                }),
        ];
    }
}
