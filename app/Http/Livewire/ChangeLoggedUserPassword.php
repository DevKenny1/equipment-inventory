<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangeLoggedUserPassword extends Component
{

    public $isOpen = false;
    public $current_password, $new_password, $confirm_new_password;

    protected $listeners = ['openChangeLoggedUserPassword'];

    protected $rules = [
        'current_password' => 'required',
        'new_password' => 'required|min:8|max:60',
        'confirm_new_password' => 'required|same:new_password',
    ];

    protected $messages = [
        "current_password.required" => "*Current password is required.",
        "new_password.required" => "*New password is required",
        "new_password.mix" => "*Password must be at least 8 characters long",
        "new_password.max" => "*Password too long.",
        "confirm_new_password.required" => "*Please confirm your password",
        "confirm_new_password.same" => "*Confirm password not matched",
    ];

    public function openChangeLoggedUserPassword()
    {
        $this->isOpen = true;
    }

    public function closeModal(): void
    {
        $this->current_password = "";
        $this->new_password = "";
        $this->confirm_new_password = "";
        $this->resetErrorBag();
        $this->isOpen = false;
    }

    public function render()
    {
        return view('livewire.change-logged-user-password');
    }

    public function changePassword()
    {
        $this->current_password = trim($this->current_password);
        $this->new_password = trim($this->new_password);
        $this->confirm_new_password = trim($this->confirm_new_password);

        //check if current password is correct
        if (!Hash::check($this->current_password, Auth::user()->password)) {
            $this->addError("current_password", "*Password incorrect.");
            return;
        }
        //check if current password and new password is unique
        if (Hash::check($this->new_password, Auth::user()->password)) {
            $this->addError("new_password", "*Current and new password must be unique.");
            return;
        }

        $this->validate();

        // change password if all validation succeed
        $isUpdated = User::where("user_id", "=", Auth::user()->user_id)
            ->update(["password" => Hash::make($this->new_password)]);


        if ($isUpdated) {
            $this->dispatchBrowserEvent('showNotification', ['title' => 'Password changed', 'message' => 'Your password was successfully updated', 'type' => 'success']);

            $this->closeModal();
            Auth::logout();
            redirect("/");
            return;
        }
        $this->dispatchBrowserEvent('showNotification', ['title' => 'Password changed', 'message' => 'Your password was not updated', 'type' => 'error']);
    }
}
