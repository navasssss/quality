<?php

namespace App\Filament\Resources\NdtReportResource\Pages;

use App\Filament\Resources\NdtReportResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNdtReport extends EditRecord
{
    protected static string $resource = NdtReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
