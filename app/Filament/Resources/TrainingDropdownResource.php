<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrainingDropdownResource\Pages;
use App\Filament\Resources\TrainingDropdownResource\RelationManagers;
use App\Models\TrainingDropdown;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TrainingDropdownResource extends Resource
{
    protected static ?string $model = TrainingDropdown::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\Select::make('type')
                ->options(TrainingDropdown::getTypeOptions())
                ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\textcolumn::make('type')
                                        ->sortable()
                     ->formatStateUsing(fn ($state) => TrainingDropdown::getTypeOptions()[$state] ?? 'Unknown')
                   ->badge(),
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
            'index' => Pages\ListTrainingDropdowns::route('/'),
            'create' => Pages\CreateTrainingDropdown::route('/create'),
            'edit' => Pages\EditTrainingDropdown::route('/{record}/edit'),
        ];
    }
}
