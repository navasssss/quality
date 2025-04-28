<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\SelectFilter;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('title')
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required(),
                Forms\Components\BelongsToSelect::make('department_id')
                ->relationship('department', 'name')
                ,
                Forms\Components\Select::make('role')
                    ->options([
                        Employee::ROLE_OWNER => 'Owner',
                        Employee::ROLE_MANAGER => 'Manager',
                        Employee::ROLE_EMPLOYEE => 'Employee',
                    ])
                    ->default(Employee::ROLE_EMPLOYEE)
                    ->required(),
                Forms\Components\BelongsToSelect::make('manager_id')
                ->relationship('manager', 'name')->hidden(fn ($get) => $get('role') == Employee::ROLE_OWNER), // Hide if Owner
                Forms\Components\FileUpload::make('profile_pic')
                  ->avatar()
                  ->moveFiles()
                  ->disk('public_uploads')
                   ->directory('org-chart'),
                Forms\Components\Textarea::make('responsibility') ->columnSpanFull()
                   ,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('department.name')
,
                Tables\Columns\TextColumn::make('role_name')->label('Role')->badge()
                    ->color(fn ($state) => match ($state) {
                        'Owner' => 'danger',
                        'Manager' => 'warning',
                        'Employee' => 'success',
                    }),
                Tables\Columns\TextColumn::make('manager.name')
                    ->sortable(),
                Tables\Columns\ImageColumn::make('profile_pic')
                    ->searchable(),
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
                SelectFilter::make('role')
                    ->options([
                        Employee::ROLE_OWNER => 'Owner',
                        Employee::ROLE_MANAGER => 'Manager',
                        Employee::ROLE_EMPLOYEE => 'Employee',
                    ]),
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
          'org-chart' => Pages\OrgChart::route('/org-chart'), 
        ];
    }
    public static function shouldRegisterNavigation(): bool
{
    return false; // Ensure it's registered in the navigation
}
}
