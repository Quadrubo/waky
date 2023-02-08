<?php

namespace App\Filament\Resources\SSHKeyResource\Pages;

use App\Filament\Resources\SSHKeyResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSSHKey extends ViewRecord
{
    protected static string $resource = SSHKeyResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
