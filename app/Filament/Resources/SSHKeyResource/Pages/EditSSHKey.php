<?php

namespace App\Filament\Resources\SSHKeyResource\Pages;

use App\Filament\Resources\SSHKeyResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSSHKey extends EditRecord
{
    protected static string $resource = SSHKeyResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
