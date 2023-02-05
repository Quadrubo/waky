<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Filament\Tables\Filters as CustomFilters;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationIcon = 'heroicon-o-users';

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
                                Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255)
                                    ->localize('app.models.user.attributes.email'),
                                Forms\Components\TextInput::make('password')
                                    ->password()
                                    ->required()
                                    ->maxLength(255)
                                    ->dehydrateStateUsing(fn ($state) => ! empty($state) ? Hash::make($state) : null)
                                    ->visibleOn('create')
                                    ->localize('app.models.user.attributes.password'),
                                Forms\Components\DateTimePicker::make('email_verified_at')
                                    ->hiddenOn('create')
                                    ->displayFormat('d.m.Y H:i:s')
                                    ->localize('app.models.user.attributes.email_verified_at'),
                            ])
                            ->columns([
                                'default' => 1,
                                'sm' => 2,
                            ]),
                        Forms\Components\Section::make(__('app.filament.forms.sections.authorization.label'))
                            ->schema([
                                Forms\Components\CheckboxList::make('roles')
                                    ->relationship('roles', 'name')
                                    ->localize('app.models.user.relations.roles'),
                            ]),
                    ])
                    ->columnSpan([
                        'default' => 1,
                        'sm' => fn (Component $livewire): int => $livewire instanceof Pages\CreateUser ? 3 : 2,
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
                                    ->localize('app.general.attributes.created_at'),
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
        $filters = [
            CustomFilters\VerifiedFilter::make(),
        ];

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->localize('app.general.attributes.id', helper: false, hint: false),
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->localize('app.general.attributes.name', helper: false, hint: false),
                Tables\Columns\TextColumn::make('email')
                    ->sortable()
                    ->searchable()
                    ->localize('app.models.user.attributes.email', helper: false, hint: false),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime('d.m.Y')
                    ->sortable()
                    ->localize('app.models.user.attributes.email_verified_at', helper: false, hint: false),
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
            ->filters($filters)
            ->defaultSort('name');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\RolesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
            'view' => Pages\ViewUser::route('/{record}'),
        ];
    }

    /**
     * Get the advanced search result Details.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $record
     * @return array
     */
    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            __('app.models.user.attributes.email.label') => $record->email,
            __('app.filament.tables.filters.verified.label') => ! is_null($record->email_verified_at) ? __('app.other.yes') : __('app.other.no'),
        ];
    }

    /**
     * Get the Eloquent query for global search. Excludes the records the user is not authorized to see.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected static function getGlobalSearchEloquentQuery(): Builder
    {
        $query = parent::getGlobalSearchEloquentQuery();

        if (! Auth::user()->hasPermissionTo('view_any_user')) {
            $query = $query->where('id', -1);
        }

        return $query;
    }

    /**
     * Gets the URL the User is redirected to after clicking on a global search result.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $record
     * @return string
     */
    public static function getGlobalSearchResultUrl(Model $record): string
    {
        return route('filament.resources.users.view', ['record' => $record]);
    }

    public static function getModelLabel(): string
    {
        return __('app.models.user.label') !== 'app.models.user.label' ? __('app.models.user.label') : parent::getModelLabel();
    }

    public static function getPluralModelLabel(): string
    {
        return __('app.models.user.plural_label') !== 'app.models.user.plural_label' ? __('app.models.user.plural_label') : parent::getPluralModelLabel();
    }

    protected static function getNavigationGroup(): ?string
    {
        return __('app.models.user.navigation_group') !== 'app.models.user.navigation_group' ? __('app.models.user.navigation_group') : parent::getNavigationGroup();
    }
}
