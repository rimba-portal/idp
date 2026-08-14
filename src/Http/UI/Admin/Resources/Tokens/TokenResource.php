<?php

declare(strict_types=1);

namespace Rimba\Http\UI\Admin\Resources\Tokens;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Laravel\Passport\Token;
use Rimba\Http\UI\Admin\Resources\Tokens\Pages\CreateToken;
use Rimba\Http\UI\Admin\Resources\Tokens\Pages\EditToken;
use Rimba\Http\UI\Admin\Resources\Tokens\Pages\ListTokens;
use Rimba\Http\UI\Admin\Resources\Tokens\Schemas\TokenForm;
use Rimba\Http\UI\Admin\Resources\Tokens\Tables\TokensTable;
use UnitEnum;

class TokenResource extends Resource
{
    protected static ?string $model = Token::class;

    protected static string|BackedEnum|null $navigationIcon = 'bites-tokens';

    protected static string|UnitEnum|null $navigationGroup = 'Tokens';

    protected static ?int $navigationSort = 1;

    // protected static ?string $modelLabel = 'Token';

    public static function form(Schema $schema): Schema
    {
        return TokenForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TokensTable::configure($table);
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
            'index' => ListTokens::route('/'),
            'create' => CreateToken::route('/create'),
            'edit' => EditToken::route('/{record}/edit'),
        ];
    }
}
