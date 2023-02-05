<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\Resources\RoleResource;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateRole extends CreateRecord
{
    protected static string $resource = RoleResource::class;

    /**
     * Returns the form actions displayed at the bottom of the page.
     *
     * @return array
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
     *
     * @return Action
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
