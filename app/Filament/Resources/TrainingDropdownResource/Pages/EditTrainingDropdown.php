<?php

namespace App\Filament\Resources\TrainingDropdownResource\Pages;

use App\Filament\Resources\TrainingDropdownResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTrainingDropdown extends EditRecord
{
    protected static string $resource = TrainingDropdownResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
