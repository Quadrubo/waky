<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Filament\Resources\RoleResource;
use App\Filament\Resources\UserResource\Pages\EditUser;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Model;

class RolesRelationManager extends RelationManager
{
    protected static string $relationship = 'roles';

    protected static ?string $recordTitleAttribute = 'name';

    public function isEditPage()
    {
        return $this->pageClass === EditUser::class;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\BadgeColumn::make('id')
                    ->localize('app.general.attributes.id', helper: false, hint: false),
                Tables\Columns\TextColumn::make('name')
                    ->localize('app.general.attributes.name', helper: false, hint: false),
                Tables\Columns\TextColumn::make('guard_name')
                    ->localize('app.models.role.attributes.guard_name', helper: false, hint: false),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                Tables\Actions\AttachAction::make()
                    ->preloadRecordSelect(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\DetachBulkAction::make(),
            ]);
    }

    public static function getModelLabel(): string
    {
        return __('app.models.role.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('app.models.role.plural_label');
    }

    protected function canAssociate(): bool
    {
        return $this->isEditPage() ? parent::canAssociate() : false;
    }

    protected function canAttach(): bool
    {
        return $this->isEditPage() ? parent::canAttach() : false;
    }

    protected function configureCreateAction(Tables\Actions\CreateAction $action): void
    {
        parent::configureCreateAction($action);

        $action
            ->action(null)
            ->url(RoleResource::getUrl('create'));
    }

    protected function canCreate(): bool
    {
        return $this->isEditPage() ? parent::canCreate() : false;
    }

    protected function canDelete(Model $record): bool
    {
        return false;
    }

    protected function canDeleteAny(): bool
    {
        return false;
    }

    protected function canDetach(Model $record): bool
    {
        return $this->isEditPage() ? parent::canDetach($record) : false;
    }

    protected function canDetachAny(): bool
    {
        return $this->isEditPage() ? parent::canDetachAny() : false;
    }

    protected function canDissociate(Model $record): bool
    {
        return $this->isEditPage() ? parent::canDissociate($record) : false;
    }

    protected function canDissociateAny(): bool
    {
        return $this->isEditPage() ? parent::canDissociateAny() : false;
    }

    protected function configureEditAction(Tables\Actions\EditAction $action): void
    {
        parent::configureEditAction($action);

        $action
            ->action(null)
            ->url(fn (Model $record): string => RoleResource::getUrl('edit', $record));
    }

    protected function canEdit(Model $record): bool
    {
        return $this->isEditPage() ? parent::canEdit($record) : false;
    }

    protected function canForceDelete(Model $record): bool
    {
        return false;
    }

    protected function canForceDeleteAny(): bool
    {
        return false;
    }

    protected function canReplicate(Model $record): bool
    {
        return $this->isEditPage() ? parent::canReplicate($record) : false;
    }

    protected function canRestore(Model $record): bool
    {
        return $this->isEditPage() ? parent::canRestore($record) : false;
    }

    protected function canRestoreAny(): bool
    {
        return $this->isEditPage() ? parent::canRestoreAny() : false;
    }

    protected function configureViewAction(Tables\Actions\ViewAction $action): void
    {
        parent::configureViewAction($action);

        $action
            ->action(null)
            ->url(fn (Model $record): string => RoleResource::getUrl('view', $record));
    }

    protected function canView(Model $record): bool
    {
        return $this->can('view', $record);
    }
}
