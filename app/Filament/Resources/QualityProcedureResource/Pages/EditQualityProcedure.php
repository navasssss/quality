<?php

namespace App\Filament\Resources\QualityProcedureResource\Pages;

use App\Filament\Resources\QualityProcedureResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditQualityProcedure extends EditRecord
{
    protected static string $resource = QualityProcedureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
