<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NdtReportResource\Pages;
use App\Filament\Resources\NdtReportResource\RelationManagers;
use App\Models\NdtReport;
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


class NdtReportResource extends Resource
{
    protected static ?string $model = NdtReport::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

     public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([
                  Forms\Components\TextInput::make('number')
                ->default(fn () => NdtReport::generateNextNumber())
                  ->readOnly()
                    ->required(),
                Forms\Components\TextInput::make('title')
                    ->required(),
               
    Forms\Components\textinput::make('revision')
                  ->numeric()
                 ->default(1)
                    ->required()
                   ,
                Forms\Components\FileUpload::make('file')
    ->disk('public_uploads')
    ->directory('ndt_report')
    ->moveFiles()
    ->label('Upload Ndt Report')
    ->acceptedFileTypes([
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    ])
    ->openable()
    ->required()
 ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file, callable $get) {
        $number = $get('number') ?? 'ndt-report';
        $revision = $get('revision') ?? '1';
        $timestamp = now()->format('YmdHis'); // Adds current timestamp

        return "{$number}-{$revision}-{$timestamp}.{$file->getClientOriginalExtension()}";
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
    ->options(NdtReport::getStatusOptions())
    ->default(NdtReport::STATUS_PENDING_REVIEW)
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
                 Tables\Columns\TextColumn::make('number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
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
    ->formatStateUsing(fn ($state) => NdtReport::getStatusOptions()[$state] ?? 'Unknown')
    ->badge()
    ->color(fn ($state) => match ($state) {
        NdtReport::STATUS_APPROVED => 'success',
        NdtReport::STATUS_PENDING_REVIEW => 'warning',
        NdtReport::STATUS_PENDING_APPROVAL => 'info',
        NdtReport::STATUS_WITHDRAWN => 'danger',
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
    !Storage::disk('public_uploads')->exists($record->file) || 
    Storage::disk('public_uploads')->mimeType($record->file) !== 'application/pdf'
)
->modalContent(fn ($record) => view('pdf-viewer', [
    'pdfUrl' => asset('uploads/' . $record->file), // Use asset() for public files
])),

Tables\Actions\Action::make('downloadFile')
    ->label('')
    ->color('info')
    ->icon('heroicon-s-arrow-down-tray')
    ->action(fn ($record) => response()->download(public_path('uploads/' . $record->file))) // Use public_path()
    ->disabled(fn ($record) => !Storage::disk('public_uploads')->exists($record->file)),
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
            'index' => Pages\ListNdtReports::route('/'),
            'create' => Pages\CreateNdtReport::route('/create'),
            'edit' => Pages\EditNdtReport::route('/{record}/edit'),
        ];
    }
}
