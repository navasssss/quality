<?php

namespace App\Filament\Resources\QualityManualResource\Pages;

use App\Filament\Resources\QualityManualResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateQualityManual extends CreateRecord
{
    protected static string $resource = QualityManualResource::class;
    
    protected function getRedirectUrl(): string
{
    return $this->getResource()::getUrl('index'); // Redirect to table
}
}
