<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ComputerResource\Pages;
use App\Filament\Resources\Concerns\ResourceMetadata;
use App\Models\Computer;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ComputerResource extends Resource
{
    use ResourceMetadata;

    protected static ?string $model = Computer::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationIcon = 'heroicon-o-desktop-computer';

    protected static ?string $translationPrefix = 'app.models.computer';

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
                                Forms\Components\TextInput::make('mac_address')
                                    ->required()
                                    ->maxLength(255)
                                    ->localize('app.models.computer.attributes.mac_address'),
                                Forms\Components\TextInput::make('ip_address')
                                    ->required()
                                    ->maxLength(255)
                                    ->localize('app.models.computer.attributes.ip_address'),
                            ])
                            ->columns([
                                'default' => 1,
                                'sm' => 2,
                            ]),
                        Forms\Components\Section::make(__('app.filament.forms.sections.ssh_information.label'))
                            ->schema([
                                Forms\Components\TextInput::make('ssh_user')
                                    ->maxLength(255)
                                    ->autofocus()
                                    ->localize('app.models.computer.attributes.ssh_user'),
                                Forms\Components\Select::make('s_s_h_key_id')
                                    ->relationship('sSHKey', 'name')
                                    ->localize('app.models.computer.relations.ssh_key'),
                                Forms\Components\TextInput::make('ssh_shutdown_command')
                                    ->maxLength(255)
                                    ->localize('app.models.computer.attributes.ssh_shutdown_command'),
                            ])
                            ->columns([
                                'default' => 1,
                                'sm' => 2,
                            ]),
                    ])
                    ->columnSpan([
                        'default' => 1,
                        'sm' => fn (Component $livewire): int => $livewire instanceof Pages\CreateComputer ? 3 : 2,
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
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->localize('app.general.attributes.id', helper: false, hint: false),
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->localize('app.general.attributes.name', helper: false, hint: false),
                Tables\Columns\TextColumn::make('mac_address')
                    ->sortable()
                    ->searchable()
                    ->localize('app.models.computer.attributes.mac_address', helper: false, hint: false),
                Tables\Columns\TextColumn::make('ip_address')
                    ->sortable()
                    ->searchable()
                    ->localize('app.models.computer.attributes.ip_address', helper: false, hint: false),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d.m.Y')
                    ->sortable()
                    ->localize('app.general.attributes.created_at', helper: false, hint: false),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('d.m.Y')
                    ->sortable()
                    ->localize('app.general.attributes.updated_at', helper: false, hint: false),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->defaultSort('name');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListComputers::route('/'),
            'create' => Pages\CreateComputer::route('/create'),
            'view' => Pages\ViewComputer::route('/{record}'),
            'edit' => Pages\EditComputer::route('/{record}/edit'),
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
            __('app.models.computer.attributes.mac_address.label') => $record->mac_address,
            __('app.models.computer.attributes.ip_address.label') => $record->ip_address,
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

        if (! Auth::user()->hasPermissionTo('view_any_computer')) {
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
        return route('filament.resources.computers.view', ['record' => $record]);
    }
}
