<?php

namespace App\Filament\Resources;
use Filament\Forms\Components\BelongsToSelect;
use App\Filament\Resources\QualityManualResource\Pages;
use App\Filament\Resources\QualityManualResource\RelationManagers;
use App\Models\QualityManual;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;
use Filament\Forms\Components\Section;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\ViewField;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
class QualityManualResource extends Resource
{
    protected static ?string $model = QualityManual::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([
                  Forms\Components\TextInput::make('document_number')
                ->default(fn () => QualityManual::generateNextDocumentNumber())
                  ->readOnly()
                    ->required(),
                Forms\Components\TextInput::make('document_title')
                    ->required(),
             
             Forms\Components\textinput::make('revision')
                  ->numeric()
                  ->default(1) 
                    ->required()
                   ,   Forms\Components\FileUpload::make('document_file')
                 ->disk('public_uploads')
    ->directory('quality_manual')
    ->moveFiles()
                ->label('Upload Document')->acceptedFileTypes([
        'application/pdf', // PDF
        'application/msword', // DOC (Old Word format)
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' // DOCX (New Word format)
    ])->openable()
    ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file, callable $get) {
        $policyNumber = $get('document_number') ?? 'document';
        $revision = $get('revision') ?? '1';
        $timestamp = now()->format('YmdHis'); // Adds current timestamp

        return "{$policyNumber}-{$revision}-{$timestamp}.{$file->getClientOriginalExtension()}";
    }),
                Forms\Components\textinput::make('revision')
                  ->numeric()
                  ->default(1) 
                    ->required()
                   ,
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
    ->options(QualityManual::getStatusOptions())
    ->default(QualityManual::STATUS_PENDING_REVIEW)
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
                Tables\Columns\TextColumn::make('document_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('document_title')
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
    ->formatStateUsing(fn ($state) => QualityManual::getStatusOptions()[$state] ?? 'Unknown')
    ->badge()
    ->color(fn ($state) => match ($state) {
        QualityManual::STATUS_APPROVED => 'success',
        QualityManual::STATUS_PENDING_REVIEW => 'warning',
        QualityManual::STATUS_PENDING_APPROVAL => 'info',
        QualityManual::STATUS_WITHDRAWN => 'danger',
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
        ->color('success')
        ->icon('heroicon-s-document-text')
        ->modalHeading('PDF Preview')
                ->slideOver()
        ->modalSubmitAction(false)
        ->modalWidth('4xl')
       ->disabled(fn ($record) => 
    !Storage::disk('public_uploads')->exists($record->document_file) || 
    Storage::disk('public_uploads')->mimeType($record->document_file) !== 'application/pdf'
)
->modalContent(fn ($record) => view('pdf-viewer', [
    'pdfUrl' => asset('uploads/' . $record->document_file), // Use asset() for public files
])),

Tables\Actions\Action::make('downloadFile')
    ->label('')
    ->color('info')
    ->icon('heroicon-s-arrow-down-tray')
    ->action(fn ($record) => response()->download(public_path('uploads/' . $record->document_file))) // Use public_path()
    ->disabled(fn ($record) => !Storage::disk('public_uploads')->exists($record->document_file)),
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
            'index' => Pages\ListQualityManuals::route('/'),
            'create' => Pages\CreateQualityManual::route('/create'),
            'edit' => Pages\EditQualityManual::route('/{record}/edit'),
        ];
    }
}
