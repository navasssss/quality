<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FeedbackResource\Pages;
use App\Filament\Resources\FeedbackResource\RelationManagers;
use App\Filament\Resources\FeedbackResource\Widgets\FeedbackStats;
use App\Models\Feedback;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FeedbackResource extends Resource
{
    protected static ?string $slug = 'feed';
    protected static ?string $model = Feedback::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('customer_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->maxLength(255)
                    ->required(),
                Forms\Components\DatePicker::make('service_date'),
                Forms\Components\Select::make('service_type')
                    ->required()
                    ->options(Feedback::service_type())
                    ->default(4),
                Forms\Components\TextInput::make('job_reference')
                    ->maxLength(255)
                    ->required(),
                Forms\Components\Select::make('location')
                    ->required()
                    ->options(Feedback::location())
                    ->default(4),
                Forms\Components\Radio::make('satisfaction_rating')
                    ->options([
                        1,
                        2,
                        3,
                        4,
                        5,

                    ])
                    ->required(),
                Forms\Components\Textarea::make('satisfied_aspects')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('improvements')
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('staff_professional')
                    ->required(),
                Forms\Components\Toggle::make('turnaround_acceptable')
                    ->required(),
                Forms\Components\Toggle::make('reports_clear')
                    ->required(),
                Forms\Components\Toggle::make('safety_confidentiality')
                    ->required(),
                Forms\Components\Toggle::make('issues_reported')
                    ->required(),
                Forms\Components\Textarea::make('issue_description')
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('issue_resolved')
                    ->required(),
                Forms\Components\Toggle::make('follow_up_requested')
                    ->required(),
                Forms\Components\Select::make('preferred_contact_method')
                    ->required()
                    ->options(Feedback::preferred_contact_method()),
                Forms\Components\Toggle::make('consent')
                    ->required(),
                Forms\Components\DatePicker::make('submitted_on')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->required()
                    ->options(Feedback::status())
                    ->default(1),
                Forms\Components\Select::make('assigned_to')
                    ->relationship('assignedTo', 'name'),
                Forms\Components\Textarea::make('internal_notes')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')

                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('service_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('preferred_contact_method')
                    ->formatStateUsing(fn($record) => Feedback::preferred_contact_method()[$record->preferred_contact_method] ?? 'Unknown')
                    ->sortable(),
                Tables\Columns\TextColumn::make('service_type')
                    ->formatStateUsing(
                        fn($record) => Feedback::service_type()[$record->service_type] ?? 'Unknown'
                    )
                    ->sortable(),
                Tables\Columns\TextColumn::make('job_reference')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('location')
                    ->formatStateUsing(fn($record) => Feedback::location()[$record->location] ?? 'Unknown')
                    ->sortable(),
                Tables\Columns\TextColumn::make('satisfaction_rating')
                    ->numeric()
                    ->sortable(),


                Tables\Columns\IconColumn::make('issue_resolved')
                    ->boolean(),
                Tables\Columns\TextColumn::make('submitted_on')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->formatStateUsing(fn($record) => Feedback::status()[$record->status] ?? 'Unknown')
                    ->sortable(),
                Tables\Columns\TextColumn::make('assignedTo.name')
                    ->sortable(),
                Tables\Columns\IconColumn::make('follow_up_requested')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->boolean(),

                Tables\Columns\IconColumn::make('consent')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->boolean(),
                Tables\Columns\IconColumn::make('staff_professional')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('turnaround_acceptable')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->boolean(),
                Tables\Columns\IconColumn::make('issues_reported')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->boolean(),
                Tables\Columns\IconColumn::make('reports_clear')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->boolean(),
                Tables\Columns\IconColumn::make('safety_confidentiality')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->boolean(),
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
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListFeedback::route('/'),
            'view' => Pages\ViewFeedback::route('/{record}'),
            // 'create' => Pages\CreateFeedback::route('/create'),
            'edit' => Pages\EditFeedback::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            FeedbackStats::class,
        ];
    }
    public static function getHeaderWidgets(): array
    {
        return [
            FeedbackStats::class,
        ];
    }
}
