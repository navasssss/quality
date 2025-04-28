<?php

namespace App\Filament\Resources\TrainingDropdownResource\Pages;

use App\Filament\Resources\TrainingDropdownResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTrainingDropdowns extends ListRecords
{
    protected static string $resource = TrainingDropdownResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
