<?php

namespace App\Filament\Resources;

use App\Filament\Resources\Concerns\ResourceMetadata;
use App\Filament\Resources\SSHKeyResource\Pages;
use App\Models\SSHKey;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class SSHKeyResource extends Resource
{
    use ResourceMetadata;

    protected static ?string $model = SSHKey::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationIcon = 'heroicon-o-key';

    protected static ?string $translationPrefix = 'app.models.ssh_key';

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
                            ])
                            ->columns([
                                'default' => 1,
                                'sm' => 2,
                            ]),
                        Forms\Components\Section::make(__('app.filament.forms.sections.additional_information.label'))
                            ->hiddenOn('create')
                            ->schema([
                                Forms\Components\Textarea::make('public_file')
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->afterStateHydrated(function (Forms\Components\Textarea $component, $state) {
                                        if (is_null($state)) {
                                            return;
                                        }

                                        if (Storage::disk('private')->exists($state)) {
                                            $component->state(Storage::disk('private')->get($state));
                                        }
                                    })
                                    ->columnSpan([
                                        'default' => 1,
                                        'sm' => 2,
                                    ])
                                    ->localize('app.models.ssh_key.attributes.public_file'),
                            ])
                            ->columns([
                                'default' => 1,
                                'sm' => 2,
                            ]),
                    ])
                    ->columnSpan([
                        'default' => 1,
                        'sm' => fn (Component $livewire): int => $livewire instanceof Pages\CreateSSHKey ? 3 : 2,
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
                Tables\Columns\TextColumn::make('public_file')
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                    ->localize('app.models.ssh_key.attributes.public_file', helper: false, hint: false),
                Tables\Columns\TextColumn::make('private_file')
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->localize('app.models.ssh_key.attributes.private_file', helper: false, hint: false),
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
            'index' => Pages\ListSSHKeys::route('/'),
            'create' => Pages\CreateSSHKey::route('/create'),
            'view' => Pages\ViewSSHKey::route('/{record}'),
            'edit' => Pages\EditSSHKey::route('/{record}/edit'),
        ];
    }

    protected static function getNavigationLabel(): string
    {
        return static::getPluralModelLabel();
    }
}
