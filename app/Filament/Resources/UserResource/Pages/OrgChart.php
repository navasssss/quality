<?php

namespace App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\Page;
use Filament\Actions;

class OrgChart extends Page
{
    protected static string $resource = UserResource::class;

    protected static string $view = 'filament.resources.user-resource.pages.org-chart';
    public function mount()
    {
        $this->users = User::all(); // Get all users
    }

    protected function getViewData(): array
    {
        return [
            'users' => $this->users,
        ];
    }
    protected function getHeaderActions(): array
    {
       return [
      //      Actions\CreateAction::make(),
        ];
    }
}
