<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EquipmentMaintenanceResource\Pages;
use App\Filament\Resources\EquipmentMaintenanceResource\RelationManagers;
use App\Models\EquipmentMaintenance;
use App\Models\Equipment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EquipmentMaintenanceResource extends Resource
{
    protected static ?string $model = EquipmentMaintenance::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('equipment_id')
                    ->options(Equipment::pluck('asset_number', 'id'))->required()
                    ->label('Asset Number')
                    ->native(false)
                    ->searchable(),
                Forms\Components\DatePicker::make('maintenance_date')
                    ->default(today())
                    ->required(),
                Forms\Components\Select::make('service_status')
                    ->required()
                    ->options(EquipmentMaintenance::getStatusOptions())
                    ->default(1),
                Forms\Components\Textarea::make('details')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('equipment.asset_number')
                    ->label('Asset No.')
                    ->sortable(),
                Tables\Columns\TextColumn::make('equipment.equipment_name')
                    ->label('Name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('equipment.manufacturer')
                    ->label('Manufacturer')
                    ->sortable(),
                Tables\Columns\TextColumn::make('equipment.test_method')
                    ->label('Method')
                    ->sortable(),
                Tables\Columns\TextColumn::make('maintenance_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\textcolumn::make('service_status')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn($state) => EquipmentMaintenance::getStatusOptions()[$state] ?? 'Unknown')
                    ->badge(),
                Tables\Columns\TextColumn::make('details')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEquipmentMaintenances::route('/'),
            'create' => Pages\CreateEquipmentMaintenance::route('/create'),
            'edit' => Pages\EditEquipmentMaintenance::route('/{record}/edit'),
        ];
    }
}
