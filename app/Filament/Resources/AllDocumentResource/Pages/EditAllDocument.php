<?php

namespace App\Filament\Resources\AllDocumentResource\Pages;

use App\Filament\Resources\AllDocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAllDocument extends EditRecord
{
    protected static string $resource = AllDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
