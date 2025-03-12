<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreatedUser extends Component
{
    public $username;

    public $employee_id = '';

    public $employees = [];

    public $role = "0";
    public $status = "1";

    protected $rules = [
        "username" => "required|max:50|min:8|unique:user|regex:/^\S*$/",
        "role" => "required",
        "status" => "required",
        "employee_id" => "required",
    ];

    protected $messages = [
        "username.required" => "*Username is required.",
        "username.max" => "*Username is too long.",
        "username.min" => "*Username must be at least 8 characters.",
        "username.unique" => "*Username is already taken.",
        "username.regex" => "*Username must not contain any spaces.",
        "employee_id.required" => "*Select employee."
    ];

    public function createUser()
    {
        $this->username = trim($this->username);

        $this->validate();

        $user = User::create([
            'employee_id' => $this->employee_id,
            'username' => $this->username,
            'password' => Hash::make($this->username . "-password"),
            'status' => $this->status,
            'role' => $this->role,
        ]);

        if ($user) {
            $this->dispatchBrowserEvent('showNotification', ['title' => 'Create new user success', 'message' => 'A new user was added to the database successfully', 'type' => 'success']);
            $this->username = "";
            $this->role = "0";
            $this->status = "1";
            $this->employee_id = '';
            $this->populateEmployees();
        } else {
            $this->dispatchBrowserEvent('showNotification', ['title' => 'Create new user error', 'message' => 'A new user was not added to the database.', 'type' => 'error']);
        }
    }

    public function backToDashboard()
    {
        return redirect()->route('dashboard');
    }

    public function populateEmployees()
    {
        $this->employees = DB::table('infosys.employee')->whereNotExists(function ($query) {
            $query->select(DB::raw(1))->from('equipmentinventory.user')->whereRaw('equipmentinventory.user.employee_id = infosys.employee.employee_id');
        })
            ->orderBy('lastname', 'asc')
            ->get()
            ->map(fn($item) => (array) $item) // Convert to array
            ->toArray();
    }

    public function mount()
    {
        $this->populateEmployees();
    }

    public function render()
    {
        return view('livewire.created-user');
    }


}
