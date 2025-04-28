<?php

namespace App\Http\Livewire;

use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class AllDocumentsTable extends Component implements HasTable
{
    use InteractsWithTable;

    protected static ?string $heading = 'All Documents';

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query($this->getQuery()) // 🔹 Fetch data from multiple tables
            ->columns([
                Tables\Columns\TextColumn::make('type')->label('Type'),
                Tables\Columns\TextColumn::make('number')->label('Number'),
                Tables\Columns\TextColumn::make('title')->label('Title'),
                Tables\Columns\TextColumn::make('revision')->label('Revision'),
            ])
            ->filters([])
            ->actions([]);
    }

    private function getQuery(): Builder
    {
        return DB::table('quality_manuals')->selectRaw("'Quality Manual' as type, document_number as number, document_title as title, revision")
            ->union(DB::table('quality_policies')->selectRaw("'Quality Policy' as type, policy_number as number, policy_title as title, revision"))
            ->union(DB::table('quality_procedures')->selectRaw("'Quality Procedure' as type, number, title, revision"))
            ->union(DB::table('ndt_reports')->selectRaw("'NDT Report' as type, number, title, revision"))
            ->union(DB::table('ndt_instructions')->selectRaw("'NDT Instruction' as type, number, title, revision"));
    }

   public function render()
    {
        return view('livewire.all-documents-table');
    }
}