<?php

namespace App\Http\Livewire\User;
use App\Models\User;
use Illuminate\Validation\Rules\Password;

use Livewire\Component;

class Create extends Component
{
    public User $user;
    public $password= '';
    public $password_confirmation= '';

    public function mount()
    {
        $this->user = new User();
    }

    protected function rules()
    {
        return [
            'user.name' => 'required|string',
            'user.username' => 'required|string',
            'password' => [ 'required', Password::defaults()],
            'password_confirmation' => 'required|same:password',
        ];
    }

    public function save()
    {
        $this->validate();
        $this->user->password = $this->password;
        $this->user->save();
        return redirect()->route('users.index');
    }

    public function render()
    {
        return view('livewire.user.create');
    }
}
