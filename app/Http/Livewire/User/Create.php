<?php

namespace App\Http\Livewire\User;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rules\Password;

use Livewire\Component;

class Create extends Component
{
    public User $user;
    public $password= '';
    public $password_confirmation= '';
    public $roles;
    public $selected_roles;

    public function mount()
    {
        $this->user = new User();
        $this->roles = Role::all();
    }

    protected function rules()
    {
        return [
            'user.name' => 'required|string',
            'user.username' => 'required|string',
            'password' => [ 'required', Password::defaults()],
            'password_confirmation' => 'required|same:password',
            'selected_roles' => 'required|array',
        ];
    }

    public function save()
    {
        $this->validate();
        $this->user->password = $this->password;
        $this->user->save();

        $this->user->assignRole($this->selected_roles);

        return redirect()->route('users.index');
    }

    public function render()
    {
        return view('livewire.user.create');
    }
}
