<?php

namespace App\Filament\Resources\SSHKeyResource\Pages;

use App\Filament\Resources\SSHKeyResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSSHKeys extends ListRecords
{
    protected static string $resource = SSHKeyResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
