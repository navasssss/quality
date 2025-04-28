<?php

namespace App\Filament\Resources\QualityPolicyResource\Pages;

use App\Filament\Resources\QualityPolicyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListQualityPolicies extends ListRecords
{
    protected static string $resource = QualityPolicyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
