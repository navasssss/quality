<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class AllDocuments extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationLabel = 'All Documents';
    protected static ?string $title = 'All Documents';
    protected static ?string $navigationIcon = 'heroicon-o-document';
    protected static string $view = 'filament.pages.all-documents';

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query($this->getQuery()) // Fetch data from multiple tables
            ->columns([
                Tables\Columns\TextColumn::make('type')->label('Type')->sortable(),
                Tables\Columns\TextColumn::make('number')->label('Number')->searchable(),
                Tables\Columns\TextColumn::make('title')->label('Title')->searchable(),
                Tables\Columns\TextColumn::make('revision')->label('Revision')->sortable(),
            ])
            ->defaultSort('type')
            ->filters([])
            ->actions([]); // Add actions if needed
    }

   private function getQuery(): \Illuminate\Database\Eloquent\Builder
{
    $query = DB::table('quality_manuals')
    ->selectRaw("'Quality Manual' as type, document_number as number, document_title as title, document_file as file, revision, ROW_NUMBER() OVER () as id")
    ->union(DB::table('quality_policies')
        ->selectRaw("'Quality Policy' as type, policy_number as number, policy_title as title, policy_file as file, revision, ROW_NUMBER() OVER () as id"))
    ->union(DB::table('quality_procedures')
        ->selectRaw("'Quality Procedure' as type, number, title, file, revision, ROW_NUMBER() OVER () as id"))
    ->union(DB::table('ndt_reports')
        ->selectRaw("'NDT Report' as type, number, title, file, revision, ROW_NUMBER() OVER () as id"))
    ->union(DB::table('ndt_instructions')
        ->selectRaw("'NDT Instruction' as type, number, title, file, revision, ROW_NUMBER() OVER () as id"));

    return \App\Models\QualityManual::query()->fromSub($query, 'documents');
}
}