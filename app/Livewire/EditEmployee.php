<?php 
namespace App\Livewire;

use Filament\Forms;
use Filament\Forms\Form;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Employee;
use App\Models\Department;
use Filament\Notifications\Notification;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;

class EditEmployee extends Component implements HasForms
{
  protected $listeners = ['editEmployee' => 'loadEmployee'];
    use InteractsWithForms, WithFileUploads;

    public $employeeId;

    public function mount()
    {
        $this->form->fill([]);
    }

    public function loadEmployee($id)
    {
        $employee = Employee::findOrFail($id);
        $this->employeeId = $employee->id;

        $this->form->fill([
            'name' => $employee->name,
            'title' => $employee->title,
            'email' => $employee->email,
            'department_id' => $employee->department_id,
            'role' => $employee->role,
            'manager_id' => $employee->manager_id,
            'responsibility' => $employee->responsibility,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('title')->required(),
                Forms\Components\TextInput::make('email')->email()->required(),
                Forms\Components\Select::make('department_id')
                    ->options(Department::pluck('name', 'id')->toArray())
                    ->required(),
                Forms\Components\Select::make('role')
                    ->options([
                        1 => 'Owner',
                        2 => 'Manager',
                        3 => 'Employee',
                    ])
                    ->required(),
                Forms\Components\Select::make('manager_id')
                    ->options(Employee::where('role', '!=', 1)->pluck('name', 'id')->toArray())
                    ->hidden(fn ($get) => $get('role') == 1),
                
            ])
            ->statePath('data');
    }

    public function save()
    {
        $employee = Employee::findOrFail($this->employeeId);
        $data = $this->form->getState();

        if (isset($data['profile_pic'])) {
            $filename = $data['profile_pic']->store('uploads', 'public');
            $data['profile_pic'] = $filename;
        }

        $employee->update($data);

        $this->dispatch('refreshOrgChart'); // Refresh chart
        $this->dispatch('closeModal'); // Close modal

        Notification::make()
            ->title('Employee Updated')
            ->success()
            ->body('The employee details have been updated.')
            ->send();
    }

    public function render()
    {
        return view('livewire.edit-employee');
    }
}