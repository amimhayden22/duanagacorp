<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageCategories extends ManageRecords
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        // Periksa apakah user memiliki role 'admin'
        if (auth()->user()->hasRole('admin')) {
            return [
                Actions\CreateAction::make(),
            ];
        }

        // Jika bukan admin, kembalikan array kosong (tidak ada tombol)
        return [];
    }
}
