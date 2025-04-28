<?php

namespace App\Filament\Resources\QualityPolicyResource\Pages;

use App\Filament\Resources\QualityPolicyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditQualityPolicy extends EditRecord
{
    protected static string $resource = QualityPolicyResource::class;

protected function mutateFormDataBeforeFill(array $data): array
{
    // Increase revision by 1 when editing
    $data['revision'] = (int) $data['revision'] + 1;

    return $data;
}
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    
      protected function getRedirectUrl(): string
{
    return $this->getResource()::getUrl('index'); // Redirect to table
}
}
