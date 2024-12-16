<?php

namespace App\Filament\Resources\MaterialResource\Pages;

use App\Filament\Resources\MaterialResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMaterials extends ListRecords
{
    protected static string $resource = MaterialResource::class;

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
