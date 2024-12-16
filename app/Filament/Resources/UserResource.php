<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama')
                            ->validationAttribute('Nama')
                            ->placeholder('Contoh: Gus Khamim')
                            ->maxLength(50)
                            ->regex('/^([A-Z][a-z]*)(\s[A-Z][a-z]*)*$/')
                            ->helperText('Nama harus diawali dengan huruf kapital dan tidak boleh mengandung angka dengan maksimal karakater 50.')
                            ->required(),
                        TextInput::make('email')
                            ->label('Email')
                            ->placeholder('Contoh: khamim@gmail.com')
                            ->email()
                            ->required(),
                        TextInput::make('password')
                            ->label('Password')
                            ->validationAttribute('Password')
                            ->placeholder('Contoh: password')
                            ->password()
                            ->revealable()
                            ->visibleOn('create')
                            ->minLength(8)
                            ->required(),
                        TextInput::make('password_confirmation')
                            ->label('Konfirmasi Password')
                            ->validationAttribute('Konfirmasi Password')
                            ->password()
                            ->revealable()
                            ->required()
                            ->visibleOn('create')
                            ->minLength(8)
                            ->same('password')
                            ->dehydrated(false),
                        Select::make('roles')
                            ->label('Role')
                            ->validationAttribute('Role')
                            ->placeholder('Pilih Role')
                            ->relationship('roles', 'name')
                            ->searchable()
                            ->preload()
                            ->reactive()
                            ->required(),
                    ])
                    ->columns(1)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('roles.name')
                    ->label('Role')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
