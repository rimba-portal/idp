<?php

declare(strict_types=1);

namespace Rimba\Http\UI\Admin\Resources\Tokens\Schemas;

use Filament\Schemas\Schema;

class TokenForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
            ]);
    }
}
