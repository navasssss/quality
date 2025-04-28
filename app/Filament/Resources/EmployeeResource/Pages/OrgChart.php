<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use Filament\Resources\Pages\Page;
use App\Models\Employee;
use App\Models\Department;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Livewire\Component;
use Livewire\Attributes\On;
use Filament\Actions\StaticAction;

class OrgChart extends Page implements HasForms
{
    use InteractsWithForms;
    protected static string $resource = EmployeeResource::class;

    protected static string $view = 'filament.resources.employee-resource.pages.org-chart';
    protected static ?string $title = 'Organisation Chart';
    public $employees = [];
    public $departments = [];
    public $colors = [];
    public $search = '';
    public function mount()
    {
        $this->loadData();
    }

    public function searchEmployee()
    {
        $this->loadData(); // Just reload data
    }
    public function loadData()
    {
        $query = Employee::with(['department', 'manager']);

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                    ->orWhere('title', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%");
            });
        }

        $this->employees = $query->get();

        // Get department details
        $this->departments = Department::pluck('name', 'id')->toArray();
        $this->colors = Department::pluck('color', 'id')->toArray();
    }

    public ?array $data = [];
    public ?Employee $selectedEmployee = null;

    public function openEditModal($employeeId)
    {
        $this->selectedEmployee = Employee::find($employeeId);



        // Convert only fillable attributes to an 

        $this->mountAction('editEmployee');
    }

    public function getActions(): array
    {
        return [
            Action::make('addEmployee')
                ->label('Add Employee')
                ->icon('heroicon-o-plus')
                ->extraAttributes(['style' => 'display: none;'])
                ->modalHeading('Add New Employee')
                ->form([
                    TextInput::make('name')->required(),
                    TextInput::make('title')->required(),
                    TextInput::make('email')->email()->required()
                        ->unique(ignoreRecord: true),
                    // 🔹 Load options manually
                    Forms\Components\Select::make('role')
                        ->options([
                            Employee::ROLE_OWNER => 'Owner',
                            Employee::ROLE_MANAGER => 'Manager',
                            Employee::ROLE_EMPLOYEE => 'Employee',
                        ])
                        ->default(Employee::ROLE_EMPLOYEE)
                        ->required()
                        ->live(),
                    Forms\Components\Select::make('department_id')
                        ->options(Department::pluck('name', 'id')->toArray())
                        ->hidden(fn($get) => $get('role') == Employee::ROLE_OWNER)
                        ->live()
                        ->preload()
                        ->createOptionForm([
                            Forms\Components\TextInput::make('name')->required(),
                            Forms\Components\ColorPicker::make('color')
                                ->label('Department Color')
                                ->default('#000000'),
                        ])
                        ->createOptionUsing(function (array $data) {
                            $department = Department::create([
                                'name' => $data['name'],
                                'color' => $data['color'] ?? '#000000',
                            ]);
                            return $department->id;
                        })
                        ->label('Select Department'),
                    Forms\Components\Select::make('manager_id')
                        ->options(
                            fn($get) =>
                            Employee::where('role', Employee::ROLE_MANAGER)
                                ->where('department_id', $get('department_id'))
                                ->pluck('name', 'id')
                                ->toArray()
                        )  // 🔹 Load options manually
                        ->hidden(fn($get) => in_array($get('role'), [Employee::ROLE_OWNER, Employee::ROLE_MANAGER]))
                        ->label('Reporting To'),
                    Forms\Components\FileUpload::make('profile_pic')
                        ->avatar()
                        ->directory('org-chart')
                        ->required(),

                    Forms\Components\Textarea::make('responsibility')->columnSpanFull(),
                ])
                ->before(function ($livewire, $record) {
                    $livewire->dispatch('open-modal', id: 'editEmployee'); // ✅ Ensure modal opens
                })
                ->action(function (array $data, Component $livewire) {
                    Employee::create($data);

                    // ✅ Dispatch Livewire event to refresh the page
                    $livewire->dispatch('refreshOrgChart');

                    // ✅ Show success notification
                    Notification::make()
                        ->title('Employee Added')
                        ->success()
                        ->body('The employee has been successfully added.')
                        ->send();
                }),

            Action::make('editEmployee')
                ->label('Edit Employee')
                ->modalSubmitAction(fn(StaticAction $action) => $action->label('Save Changes'))
                ->extraAttributes(['style' => 'display: none;'])
                ->icon('heroicon-o-pencil')
                ->modalHeading(fn() => 'Edit ' . ($this->selectedEmployee?->name ?? 'Employee'))
                ->form(fn() => [
                    TextInput::make('name')->default($this->selectedEmployee?->name)->required(),
                    TextInput::make('title')->default($this->selectedEmployee?->title)->required(),
                    TextInput::make('email')->default($this->selectedEmployee?->email)->email()->required()->unique(ignoreRecord: true),
                    Forms\Components\Select::make('role')
                        ->options([
                            Employee::ROLE_OWNER => 'Owner',
                            Employee::ROLE_MANAGER => 'Manager',
                            Employee::ROLE_EMPLOYEE => 'Employee',
                        ])
                        ->default($this->selectedEmployee?->role)
                        ->live()
                        ->required(),
                    Forms\Components\Select::make('department_id')
                        ->options(Department::pluck('name', 'id')->toArray())
                        ->hidden(fn($get) => $get('role') == Employee::ROLE_OWNER)
                        ->live()
                        ->default($this->selectedEmployee?->department_id)
                        ->label('Select Department'),

                    Forms\Components\Select::make('manager_id')
                        ->options(
                            fn($get) => Employee::where('role', Employee::ROLE_MANAGER)
                                ->where('department_id', $get('department_id'))
                                ->pluck('name', 'id')
                                ->toArray()
                        )  // 🔹 Load options manually
                        ->hidden(fn($get) => in_array($get('role'), [Employee::ROLE_OWNER, Employee::ROLE_MANAGER]))
                        ->default($this->selectedEmployee?->manager_id)
                        ->live()
                        ->label('Select Manager'),
                    Forms\Components\FileUpload::make('profile_pic')
                        ->avatar()
                        ->moveFiles()
                        ->directory('org-chart'),
                    Forms\Components\Textarea::make('responsibility')
                        ->default($this->selectedEmployee?->responsibility)
                        ->columnSpanFull(),
                ])
                ->extraModalFooterActions([
                    // 🔴 Delete Button in Modal Footer
                    Action::make('deleteEmployee')
                        ->label('Delete')
                        ->color('danger')
                        ->icon('heroicon-o-trash')
                        ->requiresConfirmation()
                        ->cancelParentActions('editEmployee')
                        ->action(fn() => $this->deleteEmployee()),
                ])
                ->action(function (array $data) {
                    if ($this->selectedEmployee) {
                        if (empty($data['profile_pic'])) {
                            unset($data['profile_pic']); // Remove profile_pic from update array
                        }
                        $this->selectedEmployee->update($data);
                        Notification::make()
                            ->title('Updated Successfully')
                            ->success()
                            ->body('Employee details updated.')
                            ->send();
                    }
                }),
        ];
    }

    public function deleteEmployee()
    {
        if ($this->selectedEmployee) {
            $this->selectedEmployee->delete();
            Notification::make()
                ->title('Deleted Successfully')
                ->success()
                ->body('Employee has been deleted.')
                ->send();
        }
    }
    #[On('refreshOrgChart')]
    public function refreshOrgChart()
    {
        $this->loadData(); // ✅ Reload data when event is triggered
    }
    protected function getViewData(): array
    {
        return [
            'employees' => $this->employees,
            'departments' => $this->departments,
            'colors' => $this->colors,
        ];
    }
}
