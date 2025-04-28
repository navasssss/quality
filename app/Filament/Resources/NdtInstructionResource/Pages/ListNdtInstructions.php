<?php

namespace App\Filament\Resources\NdtInstructionResource\Pages;

use App\Filament\Resources\NdtInstructionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNdtInstructions extends ListRecords
{
    protected static string $resource = NdtInstructionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
