<?php

namespace App\Filament\Resources\QualityManualResource\Pages;

use App\Filament\Resources\QualityManualResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListQualityManuals extends ListRecords
{
    protected static string $resource = QualityManualResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
