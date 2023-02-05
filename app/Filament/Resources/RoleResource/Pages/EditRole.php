<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\Resources\RoleResource;
use Filament\Pages\Actions;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditRole extends EditRecord
{
    protected static string $resource = RoleResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    /**
     * Returns the form actions displayed at the bottom of the page.
     *
     * @return array
     */
    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction(),
            $this->getSaveAndBackFormAction(),
            $this->getCancelFormAction(),
        ];
    }

    /**
     * Returns the ButtonAction for saving an entry and going back
     * to the resource view page.
     *
     * @return Action
     */
    protected function getSaveAndBackFormAction(): Action
    {
        return Action::make('saveBack')
            ->label(__('app.filament.forms.actions.save_and_back.label'))
            ->action('saveAndBack')
            ->color('secondary');
    }

    /**
     * Redirects back to the resource view page after saving an entry.
     */
    public function saveAndBack(): void
    {
        $this->save();

        $this->redirect(url(static::getResource()::getUrl()));
    }
}
