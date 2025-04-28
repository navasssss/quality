<?php

namespace App\Filament\Resources\QualityManualResource\Pages;

use App\Filament\Resources\QualityManualResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditQualityManual extends EditRecord
{
    protected static string $resource = QualityManualResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    
    protected function mutateFormDataBeforeFill(array $data): array
{
    // Increase revision by 1 when editing
    $data['revision'] = (int) $data['revision'] + 1;

    return $data;
}
  
    protected function getRedirectUrl(): string
{
    return $this->getResource()::getUrl('index'); // Redirect to table
}
}
