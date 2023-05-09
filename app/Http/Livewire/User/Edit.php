<?php

namespace App\Http\Livewire\User;
use App\Models\User;

use Livewire\Component;

class Edit extends Component
{
    public User $user;
    public string $name;
    public string $username;
    public string $status;
    public string $password = '';
    public string $password_confirmation = '';
     

    protected $rules = [
        'name' => 'required|string',
        'username' => 'required|string',
        'password' => 'nullable|string',
        'password_confirmation' => 'nullable|same:new_password',

        // 'new_password'     => 'required',
        //     'password_confirmation' => 'required|same:new_password',
    ];

    public function mount(User $user)
    {
        $this->name = $user->name;
        $this->username = $user->username;
        $this->status = $user->status ? "true" : "false"; 
    }

    public function render()
    {
        return view('livewire.user.edit');
    }

    public function save() {
        $this->validate();

        $this->user->name = $this->name;
        $this->user->username = $this->username;
        $this->user->status = $this->status;

        if($this->password && $this->password_confirmation){
            $this->user->password = $this->password;
        }

        $this->user->save();
        return redirect()->route('users.index');
    }

    public function getSelected($status) {
        return  $status ? 'selected' : '';
    }


}
