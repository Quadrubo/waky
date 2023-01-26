<?php

namespace App\Filament\Resources\ComputerResource\Pages;

use App\Filament\Resources\ComputerResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewComputer extends ViewRecord
{
    protected static string $resource = ComputerResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
