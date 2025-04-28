<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrainingProgramResource\Pages;
use App\Filament\Resources\TrainingProgramResource\RelationManagers;
use App\Models\TrainingProgram;
use App\Models\TrainingDropdown;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TrainingProgramResource extends Resource
{
    protected static ?string $model = TrainingProgram::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->required()
                    ->relationship('user', 'name')->label('Employee'),
                Forms\Components\Select::make('training')
                    ->required()
                    ->live()
                    ->options(TrainingDropdown::getTypeOptions()),
                Forms\Components\Select::make('designation')
                    ->required()
                    ->options(fn(callable $get) => TrainingProgram::getDesignationOptions($get('training'))),
                Forms\Components\Select::make('department')
                    ->required()
                    ->options(fn(callable $get) => TrainingProgram::getDepartmentOptions($get('training'))),
                Forms\Components\Select::make('module')
                    ->required()
                    ->options(fn(callable $get) => TrainingDropdown::getOptions($get('training'))),

                Forms\Components\TextInput::make('trainer_name')
                    ->required(),
                Forms\Components\Select::make('mode')
                    ->required()
                    ->options(fn(callable $get) => TrainingProgram::getModeOptions($get('training'))),
                Forms\Components\Select::make('training_type')
                    ->required()
                    ->options(TrainingProgram::getTrainingTypeOptions()),
                Forms\Components\DatePicker::make('training_date')
                    ->required()
                    ->afterStateUpdated(
                        fn($set, $get) =>
                        $set(
                            'refresher_due',
                            !empty($get('training_date')) && !empty($get('validity'))
                                ? \Carbon\Carbon::parse($get('training_date'))->addMonths((int)$get('validity'))->format('Y-m-d')
                                : null
                        )
                    )
                    ->reactive(), // Reacts to changes

                Forms\Components\TextInput::make('validity')
                    ->numeric()
                    ->afterStateUpdated(
                        fn($set, $get) =>
                        $set(
                            'refresher_due',
                            !empty($get('training_date')) && !empty($get('validity'))
                                ? \Carbon\Carbon::parse($get('training_date'))->addMonths((int)$get('validity'))->format('Y-m-d')
                                : null
                        )
                    )
                    ->helperText('Enter the validity period in months. Leave blank for unlimited validity')
                    ->reactive(), // Reacts to changes

                Forms\Components\DatePicker::make('refresher_due')
                    ->readOnly() // Default value to prevent errors
                ,

                Forms\Components\Select::make('status')
                    ->required()
                    ->options(TrainingProgram::getStatusOptions()),
                Forms\Components\FileUpload::make('attachments')
                    ->multiple()
                    ->downloadable()
                    ->acceptedFileTypes(['image/*', 'application/pdf'])
                    ->helperText('Upload images or PDFs. Optimize file size for better performance.')
                    ->directory('training')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')

                    ->sortable(),
                Tables\Columns\TextColumn::make('training')
                    ->formatStateUsing(fn($state) => TrainingDropdown::getTypeOptions()[$state] ?? 'Unknown')
                    ->sortable(),
                Tables\Columns\TextColumn::make('designation')
                    ->formatStateUsing(fn($state, $record) => TrainingProgram::getDesignationOptions($record->training)[$state] ?? 'Unknown')
                    ->sortable(),
                Tables\Columns\TextColumn::make('department')
                    ->formatStateUsing(fn($state, $record) => TrainingProgram::getDepartmentOptions($record->training)[$state] ?? 'Unknown')
                    ->sortable(),
                Tables\Columns\TextColumn::make('module')
                    ->formatStateUsing(fn($state) => TrainingDropdown::getValue($state) ?? 'Unknown')
                    ->searchable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('trainer_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('mode')
                    ->formatStateUsing(fn($state, $record) => TrainingProgram::getModeOptions($record->training)[$state] ?? 'Unknown')

                    ->sortable(),
                Tables\Columns\TextColumn::make('training_type')
                    ->formatStateUsing(fn($state) => TrainingProgram::getTrainingTypeOptions()[$state] ?? 'Unknown')
                    ->sortable(),
                Tables\Columns\TextColumn::make('validity')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('training_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('refresher_due')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->formatStateUsing(fn($state) => TrainingProgram::getStatusOptions()[$state] ?? 'Unknown')
                    ->sortable(),
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
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListTrainingPrograms::route('/'),
            'create' => Pages\CreateTrainingProgram::route('/create'),
            'edit' => Pages\EditTrainingProgram::route('/{record}/edit'),
            'view' => Pages\ViewTrainingProgram::route('/{record}/view'),
        ];
    }
}
