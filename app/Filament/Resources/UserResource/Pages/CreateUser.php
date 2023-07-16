<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Pages\Actions;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    /**
     * Returns the form actions displayed at the bottom of the page.
     */
    protected function getFormActions(): array
    {
        return array_merge(
            [$this->getCreateFormAction()],
            static::canCreateAnother() ? [$this->getCreateAnotherFormAction()] : [],
            [$this->getCreateAndBackFormAction()],
            [$this->getCancelFormAction()],
        );
    }

    /**
     * Returns the ButtonAction for creating an entry and going back
     * to the resource view page.
     */
    protected function getCreateAndBackFormAction(): Action
    {
        return Action::make('createBack')
            ->label(__('app.filament.forms.actions.create_and_back.label'))
            ->action('createAndBack')
            ->color('secondary');
    }

    /**
     * Redirects back to the resource view page after creating an entry.
     */
    public function createAndBack(): void
    {
        $this->create();

        $this->redirect(url(static::getResource()::getUrl()));
    }
}
