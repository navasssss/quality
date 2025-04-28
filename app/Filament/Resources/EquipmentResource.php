<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EquipmentResource\Pages;
use App\Filament\Resources\EquipmentResource\RelationManagers;
use App\Models\Equipment;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Entry;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Actions\Action;
use Illuminate\Support\Facades\Response;

class EquipmentResource extends Resource
{
    protected static ?string $model = Equipment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('asset_number')
                    ->label('Asset Number')
                    ->required()
                    ->unique(ignoreRecord: true),

                TextInput::make('equipment_name')
                    ->label('Equipment Name')
                    ->required(),

                TextInput::make('equipment_party')
                    ->label('Equipment Party')
                    ->required(),

                TextInput::make('test_method')
                    ->label('Test Method')
                    ->required(),

                TextInput::make('manufacturer')
                    ->label('Manufacturer')
                    ->required(),

                TextInput::make('manufacturer_model')
                    ->label('Manufacturer Model')
                    ->required(),

                TextInput::make('serial_number')
                    ->label('Serial Number')
                    ->required()
                    ->unique(ignoreRecord: true),

                DatePicker::make('calibration_date')
                    ->label('Calibration Date')
                    ->nullable(),

                TextInput::make('frequency')
                    ->label('Calibration Frequency (Months)')
                    ->numeric()
                    ->nullable(),

                DatePicker::make('due_date')
                    ->label('Calibration Due Date')
                    ->nullable(),

                Select::make('status')
                    ->label('Calibration Status')
                    ->options(Equipment::getStatusOptions())
                    ->default(Equipment::STATUS_CALIBRATED)
                    ->default(1),

                Select::make('condition')
                    ->options(Equipment::getConditionOptions())
                    ->default(Equipment::CONDITION_IN_SERVICE)
                    ->default(1),

                Textarea::make('repair_details')
                    ->label('Repair Details')
                    ->nullable()
                    ->hidden(fn($get) => $get('condition') == 1), // Hide if in service

                FileUpload::make('certificate')
                    ->label('Upload Calibration Certificate')
                    ->image()
                    ->directory('certificates')
                    ->imagePreviewHeight(100)
                    ->moveFiles()
                    ->previewable(true)
                    ->required(),

                FileUpload::make('photographs')
                    ->label('Attach Photographs')
                    ->multiple()
                    ->image()
                    ->moveFiles()
                    ->directory('photos')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('asset_number')->searchable(),
                TextColumn::make('equipment_name')->sortable(),
                TextColumn::make('manufacturer'),
                TextColumn::make('serial_number'),
                TextColumn::make('status')
                    ->formatStateUsing(fn($state) => Equipment::getStatusOptions()[$state] ?? 'Unknown')
                    ->badge(),
                ImageColumn::make('certificate')
                    ->circular(), // Custom URL

                ImageColumn::make('photographs')
                    ->circular()
                    ->stacked()
                    ->limit(3)
                    ->limitedRemainingText(), // Custom URL,
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('downloadFile')
                    ->label('')
                    ->color('info')
                    ->icon('heroicon-s-arrow-down-tray')
                    ->action(fn($record) => response()->download(storage_path('app/public/' . $record->certificate))) // Use public_path()
                    ->disabled(fn($record) => !Storage::disk('public')->exists($record->certificate)),
                Tables\Actions\ViewAction::make()
                    ->label(''),
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



    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([

            // 🔹 General Equipment Details Section
            Section::make('Equipment Details')
                ->columns(2)
                ->schema([
                    TextEntry::make('asset_number')->label('Asset Number')->columnSpan(1),
                    TextEntry::make('equipment_name')->label('Equipment Name')->columnSpan(1),
                    TextEntry::make('equipment_party')->label('Equipment Party')->columnSpan(1),
                    TextEntry::make('test_method')->label('Test Method')->columnSpan(1),
                    TextEntry::make('manufacturer')->label('Manufacturer')->columnSpan(1),
                    TextEntry::make('manufacturer_model')->label('Manufacturer Model')->columnSpan(1),
                    TextEntry::make('serial_number')->label('Serial Number')->columnSpan(1),

                ]),

            // 🔹 Calibration Details Section
            Section::make('Calibration Details')
                ->columns(2)
                ->schema([
                    TextEntry::make('calibration_date')
                        ->label('Calibration Date')
                        ->formatStateUsing(fn($state) => $state ? \Carbon\Carbon::parse($state)->format('d-m-Y (D)') : '-')
                        ->columnSpan(1),

                    TextEntry::make('due_date')
                        ->label('Calibration Due Date')
                        ->formatStateUsing(fn($state) => $state ? \Carbon\Carbon::parse($state)->format('d-m-Y (D)') : '-')
                        ->columnSpan(1),
                    TextEntry::make('repair_details')
                        ->label('Repair Details')
                        ->columnSpanFull(), // Hide if in
                    TextEntry::make('frequency')->label('Calibration Frequency (Months)')->columnSpan(1),
                    TextEntry::make('status')
                        ->label('Calibration Status')
                        ->formatStateUsing(fn($state) => Equipment::getStatusOptions()[$state] ?? 'Unknown')
                        ->columnSpan(1),
                    TextEntry::make('condition')
                        ->label('Condition')
                        ->formatStateUsing(fn($state) => Equipment::getConditionOptions()[$state] ?? 'Unknown')
                        ->columnSpan(1),
                ]),

            // 🔹 Certificate & Photographs Section
            Section::make('Certificate & Photographs')
                ->headerActions([
                    Action::make('download_certificate')
                        ->label('Certificate')
                        ->icon('heroicon-s-arrow-down-tray')
                        ->color('primary')
                        ->action(fn($record) => static::downloadCertificate($record))
                        ->hidden(fn($record) => empty($record->certificate)) // Hide if no file
                    // Full width for better display
                    ,
                    Action::make('download_photos')
                        ->label('Photographs')
                        ->icon('heroicon-s-arrow-down-tray')
                        ->color('primary')
                        ->action(fn($record) => static::downloadPhotos($record))
                        ->hidden(fn($record) => empty($record->photographs)),
                ])
                ->schema([
                    // ✅ Certificate Image
                    ImageEntry::make('certificate')
                        ->label('Calibration Certificate')

                        ->hidden(fn($record) => empty($record->certificate))
                        ->size(150),

                    // ✅ Multiple Photos
                    ImageEntry::make('photographs')
                        ->label('Equipment Photos')
                        ->size(150)

                        ->hidden(fn($record) => empty($record->photographs)),
                ]),
        ]);
    }

    public static function downloadPhotos($record)
    {
        $zipFileName = 'equipment_photos_' . $record->id . '.zip';
        $zipPath = storage_path('app/public/' . $zipFileName);

        $zip = new \ZipArchive();
        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {
            foreach ($record->photographs as $photo) {
                $filePath = storage_path('app/public/' . $photo);
                if (Storage::disk('public')->exists($photo)) {
                    $zip->addFile($filePath, $photo);
                }
            }
            $zip->close();
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }
    public static function downloadCertificate($record)
    {
        $filePath = storage_path('app/public/' . $record->certificate); // Get full storage path

        if (!Storage::disk('public')->exists($record->certificate)) {
            abort(404, 'File not found.');
        }

        return response()->download($filePath);
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
            'index' => Pages\ListEquipment::route('/'),
            'create' => Pages\CreateEquipment::route('/create'),
            'edit' => Pages\EditEquipment::route('/{record}/edit'),
            'view' => Pages\ViewEquipment::route('/{record}/view'),
        ];
    }
}
