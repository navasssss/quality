<?php

namespace App\Filament\Resources\NdtReportResource\Pages;

use App\Filament\Resources\NdtReportResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNdtReports extends ListRecords
{
    protected static string $resource = NdtReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
