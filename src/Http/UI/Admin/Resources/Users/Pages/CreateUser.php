<?php

declare(strict_types=1);

namespace Rimba\Http\UI\Admin\Resources\Users\Pages;

use Filament\Resources\Pages\CreateRecord;
use Rimba\Http\UI\Admin\Resources\Users\UserResource;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}
