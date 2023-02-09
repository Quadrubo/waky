<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SSHKeyResource\Pages;
use App\Models\SSHKey;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class SSHKeyResource extends Resource
{
    protected static ?string $model = SSHKey::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                // Forms\Components\TextInput::make('public_file')
                //     ->required()
                //     ->maxLength(255),
                // Forms\Components\TextInput::make('private_file')
                //     ->required()
                //     ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('public_file'),
                Tables\Columns\TextColumn::make('private_file'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
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
}
