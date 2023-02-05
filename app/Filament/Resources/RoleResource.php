<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use App\Filament\Resources\RoleResource\RelationManagers;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make(__('app.filament.forms.sections.general_information.label'))
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->autofocus()
                                    ->localize('app.general.attributes.name'),
                                Forms\Components\TextInput::make('guard_name')
                                    ->required()
                                    ->maxLength(255)
                                    ->localize('app.models.role.attributes.guard_name'),
                                Forms\Components\Select::make('permissions')
                                    ->multiple()
                                    ->relationship('permissions', 'name')
                                    ->preload(true)
                                    ->localize('app.models.role.relations.permissions'),
                            ])
                            ->columns([
                                'default' => 1,
                                'sm' => 2,
                            ]),
                    ])
                    ->columnSpan([
                        'default' => 1,
                        'sm' => fn (Component $livewire): int => $livewire instanceof Pages\CreateRole ? 3 : 2,
                    ]),
                Forms\Components\Group::make()
                    ->hiddenOn('create')
                    ->schema([
                        Forms\Components\Section::make(__('app.filament.forms.sections.metadata.label'))
                            ->schema([
                                Forms\Components\DateTimePicker::make('created_at')
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->displayFormat('d.m.Y H:i:s')
                                    ->localize('app.general.attributes.created_at'),
                                Forms\Components\DateTimePicker::make('updated_at')
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->displayFormat('d.m.Y H:i:s')
                                    ->localize('app.general.attributes.updated_at'),
                            ])
                            ->columns([
                                'default' => 1,
                            ]),
                    ]),
            ])->columns([
                'default' => 1,
                'sm' => 3,
                'lg' => null,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->localize('app.general.attributes.id', helper: false, hint: false),
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->localize('app.general.attributes.name', helper: false, hint: false),
                Tables\Columns\TextColumn::make('guard_name')
                    ->sortable()
                    ->searchable()
                    ->localize('app.models.role.attributes.guard_name', helper: false, hint: false),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d.m.Y')
                    ->sortable()
                    ->localize('app.general.attributes.created_at', helper: false, hint: false),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('d.m.Y')
                    ->sortable()
                    ->localize('app.general.attributes.updated_at', helper: false, hint: false),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->filters([
                //
            ])
            ->defaultSort('name');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\PermissionsRelationManager::class,
            RelationManagers\UsersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
            'view' => Pages\ViewRole::route('/{record}'),
        ];
    }

    public static function getModelLabel(): string
    {
        return __('app.models.role.label') !== 'app.models.role.label' ? __('app.models.role.label') : parent::getModelLabel();
    }

    public static function getPluralModelLabel(): string
    {
        return __('app.models.role.plural_label') !== 'app.models.role.plural_label' ? __('app.models.role.plural_label') : parent::getPluralModelLabel();
    }

    protected static function getNavigationGroup(): ?string
    {
        return __('app.models.role.navigation_group') !== 'app.models.role.navigation_group' ? __('app.models.role.navigation_group') : parent::getNavigationGroup();
    }
}
