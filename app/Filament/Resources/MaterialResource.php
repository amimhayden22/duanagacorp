<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Material;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Faker\Provider\ar_EG\Text;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\MaterialResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\MaterialResource\RelationManagers;

class MaterialResource extends Resource
{
    protected static ?string $model = Material::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Hidden::make('user_id')
                            ->default(auth()->id()),
                        TextInput::make('name')
                            ->label('Nama')
                            ->validationAttribute('Nama')
                            ->placeholder('Contoh: Kosmetik')
                            ->helperText('Nama Bahan harus diawali dengan huruf kapital dan tidak boleh mengandung angka dengan maksimal karakater 100.')
                            ->maxLength(100)
                            ->regex('/^([A-Z][a-z]*)(\s[A-Z][a-z]*)*$/')
                            ->required(),
                        TextInput::make('price')
                            ->label('Harga')
                            ->validationAttribute('Harga')
                            ->placeholder('Contoh: 100000.00')
                            ->helperText('Harga harus diawali dengan angka dan tidak boleh mengandung huruf')
                            ->required(),
                        TextInput::make('stock')
                            ->label('Stok')
                            ->validationAttribute('Stok')
                            ->placeholder('Contoh: 100')
                            ->helperText('Stok harus diawali dengan angka dan tidak boleh mengandung huruf.')
                            ->numeric()
                            ->minValue(1)
                            ->regex('/^[0-9]*$/')
                            ->required(),
                        DatePicker::make('date_input')
                            ->label('Tanggal Masuk')
                            ->validationAttribute('Tanggal Masuk')
                            ->placeholder('Contoh: 2024-12-16')
                            ->date()
                            ->required(),
                        Select::make('category_id')
                            ->label('Kategori')
                            ->validationAttribute('Kategori')
                            ->relationship('category', 'name')
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
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('price')
                    ->label('Harga')
                    ->sortable(),
                TextColumn::make('stock')
                    ->label('Stok')
                    ->sortable(),
                TextColumn::make('date_input')
                    ->label('Tanggal Masuk')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Dibuat oleh'),
            ])
            ->filters([
                Filter::make('date_input')
                    ->label('Tanggal Masuk')
                    ->form([
                        DatePicker::make('created_from'),
                        DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('date_input', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('date_input', '<=', $date),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListMaterials::route('/'),
            'create' => Pages\CreateMaterial::route('/create'),
            'edit' => Pages\EditMaterial::route('/{record}/edit'),
        ];
    }
}
