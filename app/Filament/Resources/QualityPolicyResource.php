<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QualityPolicyResource\Pages;
use App\Filament\Resources\QualityPolicyResource\RelationManagers;
use App\Models\QualityPolicy;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\BelongsToSelect;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

use Illuminate\Support\Carbon;
use Filament\Forms\Components\Section;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\ViewField;

class QualityPolicyResource extends Resource
{
    protected static ?string $model = QualityPolicy::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
    return $form
            ->schema([
                Section::make()->schema([
                  Forms\Components\TextInput::make('policy_number')
                ->default(fn () => QualityPolicy::generateNextPolicyNumber())
                  ->readOnly()
                    ->required(),
                Forms\Components\TextInput::make('policy_title')
                    ->required(),
               
    Forms\Components\textinput::make('revision')
                  ->numeric()
                 ->default(1)
                    ->required()
                   ,
                Forms\Components\FileUpload::make('policy_file')
    ->disk('public_uploads')
    ->directory('quality_policy')
    ->moveFiles()
    ->label('Upload Policy')
    ->acceptedFileTypes([
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    ])
    ->openable()
    ->required()
 ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file, callable $get) {
        $policyNumber = $get('policy_number') ?? 'policy';
        $revision = $get('revision') ?? '1';
        $timestamp = now()->format('YmdHis'); // Adds current timestamp

        return "{$policyNumber}-{$revision}-{$timestamp}.{$file->getClientOriginalExtension()}";
    }),
    Forms\Components\DatePicker::make('create_date')
                    ->native(false)
                   ->closeOnDateSelection()
                   ->default(Carbon::now())
                    ->required(),
                Forms\Components\DatePicker::make('approved_date')
                    ->native(false)
                   ->closeOnDateSelection(),
                BelongsToSelect::make('prepared_by')
                ->relationship('preparedBy', 'name')
                ->required(),

            BelongsToSelect::make('reviewed_by')
                ->relationship('reviewedBy', 'name')
                ->required(),

            BelongsToSelect::make('approved_by')
                ->relationship('approvedBy', 'name')
                ->required(),
                Forms\Components\Textarea::make('comments')
                    ->columnSpanFull(),
                Forms\Components\Select::make('status')
                    ->label('Status')
    ->options(QualityPolicy::getStatusOptions())
    ->default(QualityPolicy::STATUS_PENDING_REVIEW)
    ->required(),
                Forms\Components\Toggle::make('auditable')
                    ->required(),
                  ])->columnSpan(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                 Tables\Columns\TextColumn::make('policy_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('policy_title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('revision')
                    ->searchable(),
           
                Tables\Columns\TextColumn::make('approved_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('preparedBy.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('reviewedBy.name')                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('approvedBy.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('auditedBy.name')
                    ->sortable(),
                Tables\Columns\IconColumn::make('auditable')
                    ->boolean(),
                Tables\Columns\TextColumn::make('status')
    ->label('Status')
    ->formatStateUsing(fn ($state) => QualityPolicy::getStatusOptions()[$state] ?? 'Unknown')
    ->badge()
    ->color(fn ($state) => match ($state) {
        QualityPolicy::STATUS_APPROVED => 'success',
        QualityPolicy::STATUS_PENDING_REVIEW => 'warning',
        QualityPolicy::STATUS_PENDING_APPROVAL => 'info',
        QualityPolicy::STATUS_WITHDRAWN => 'danger',
        default => 'gray',
    }),
    
                Tables\Columns\TextColumn::make('create_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('comments')
                   
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
       Tables\Actions\Action::make('viewPdf')
        ->label('')
        ->slideOver()
        ->modalSubmitAction(false)
        ->color('success')
        ->icon('heroicon-s-document-text')
        ->modalHeading('PDF Preview')
        ->modalWidth('4xl')
       ->disabled(fn ($record) => 
    !Storage::disk('public_uploads')->exists($record->policy_file) || 
    Storage::disk('public_uploads')->mimeType($record->policy_file) !== 'application/pdf'
)
->modalContent(fn ($record) => view('pdf-viewer', [
    'pdfUrl' => asset('uploads/' . $record->policy_file), // Use asset() for public files
])),

Tables\Actions\Action::make('downloadFile')
    ->label('')
    ->color('info')
    ->icon('heroicon-s-arrow-down-tray')
    ->action(fn ($record) => response()->download(public_path('uploads/' . $record->policy_file))) // Use public_path()
    ->disabled(fn ($record) => !Storage::disk('public_uploads')->exists($record->policy_file)),
     Tables\Actions\EditAction::make()
    ->label(''),
    Tables\Actions\DeleteAction::make()
    ->label(''),
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
            'index' => Pages\ListQualityPolicies::route('/'),
            'create' => Pages\CreateQualityPolicy::route('/create'),
            'edit' => Pages\EditQualityPolicy::route('/{record}/edit'),
        ];
    }
}
