<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ModifyUser extends Component
{

    public $current_username;
    public $logged_in_employee_id;
    public $user_id, $username, $status, $role, $password = '', $employee_id = '';
    public $isOpen = false; // Track modal state

    protected $listeners = ['openEditUser']; // Listen for events from the table component

    protected $rules = [
        'username' => 'required|min:8|max:60|regex:/^\S*$/',
    ];

    protected $messages = [
        "username.required" => "*Username is required.",
        "username.min" => "*Username must be at least 8 characters",
        "username.max" => "*Username too long.",
        "username.regex" => "*Username must not contain any spaces.",
    ];

    public function openEditUser($user_id)
    {
        $user = User::find($user_id);
        if ($user) {
            $this->logged_in_employee_id = Auth::user()->employee_id;
            $this->employee_id = $user->employee_id;
            $this->user_id = $user->user_id;
            $this->username = $user->username;
            $this->current_username = $user->username;
            $this->status = $user->status;
            $this->role = $user->role;
            $this->isOpen = true;
        }
    }

    public function resetPassword()
    {
        $resetPassword = User::where('user_id', $this->user_id)->update([
            'password' => Hash::make($this->username . '-password')
        ]);

        if ($resetPassword) {
            $this->dispatchBrowserEvent('showNotification', [
                'title' => 'User password reset success',
                'message' => 'Password reset successful.',
                'type' => 'success'
            ]);
            $this->closeModal();
        }
    }

    public function changePassword()
    {

        if (strlen(trim(($this->password))) < 8) {
            $this->addError('password', '*Password must be at least 8 characters.');
            return;
        }

        $changePassword = User::where('user_id', $this->user_id)->update([
            'password' => Hash::make($this->password)
        ]);

        if ($changePassword) {
            $this->dispatchBrowserEvent('showNotification', [
                'title' => 'User password successfully changed',
                'message' => 'Password change successful.',
                'type' => 'success'
            ]);
            $this->password = '';
            $this->closeModal();
        }
    }


    public function deleteUser()
    {
        if (User::where('role', '=', 1)->count() <= 1 && $this->role == 1) {
            $this->dispatchBrowserEvent('showNotification', [
                'title' => 'User delete failed',
                'message' => 'A user can\'t deleted if only one admin exists.',
                'type' => 'error'
            ]);
            $this->closeModal();
            return;
        }


        $deleted = DB::table('user')->where('user_id', $this->user_id)->delete();

        if ($deleted) {
            $this->dispatchBrowserEvent('showNotification', [
                'title' => 'User delete',
                'message' => 'User deleted successfully.',
                'type' => 'success'
            ]);

            if (Auth::user()->user_id == $this->user_id) {
                Auth::logout();
                session()->invalidate();
                session()->regenerateToken();
                return redirect(to: "/");
            }

            // Emit event to table component to refresh data
            $this->emit('refreshUsers');

            $this->closeModal();
        }
    }

    public function modifyUser()
    {

        $this->username = trim($this->username);

        $this->validate();

        if (User::where('role', '=', 1)->count() <= 1 && $this->role == 0 && Auth::user()->user_id == $this->user_id) {
            $this->dispatchBrowserEvent('showNotification', [
                'title' => 'User role modify failed',
                'message' => 'A user with the role of admin cannot be change if there is only one admin.',
                'type' => 'error'
            ]);
            $this->closeModal();
            return;
        }

        // to allow update if the username is not changed, bypassing the unique filter
        if ($this->current_username != $this->username) {
            $user = User::where('username', "=", $this->username)->first();

            if ($user) {
                $this->addError('username', '*Username already exists.');
                return;
            }
        }


        $user = User::where("user_id", $this->user_id)->update([
            'username' => $this->username,
            'status' => $this->status,
            'role' => $this->role,
        ]);

        if ($user) {
            // Emit event to table component to refresh data
            $this->emit('refreshUsers');

            // Keep modal open and show success message
            $this->dispatchBrowserEvent('showNotification', [
                'title' => 'User Updated',
                'message' => 'User details updated successfully.',
                'type' => 'success'
            ]);
        }
        $this->closeModal();

    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.modify-user');
    }
}
