<?php

namespace App\Http\Livewire\User;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
// use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Validator;


use Livewire\Component;

class Edit extends Component
{
    public User $user;
    public string $name;
    public string $username;
    public string $status;
    public string $password = '';
    public string $password_confirmation = '';
    public string $asda = '';
     

    protected $rules = [
        'name' => 'required|string',
        'username' => 'required|string',
        // 'password' => ['required', Password::defaults()],
        // 'password' => 'required|string',
        // 'password_confirmation' => 'required|same:password',
    ];

    public function mount(User $user)
    {
        $this->name = $user->name;
        $this->username = $user->username;
        // $this->password = $user->password;
        // $this->password_confirmation = $user->password;
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
       

        if($this->password || $this->password_confirmation){

            $input = [
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
            ];
             
            $validator = Validator::make($input, [
                'password' => ['required', Password::defaults()],
                'password_confirmation' => 'required|same:password'
            ]);

            $validator->safe()->only(['password_confirmation','password']);
            $this->user->password = $this->password;

        }

        $this->user->save();
        return redirect()->route('users.index');
    }
    

    public function getSelected($status) {
        return  $status ? 'selected' : '';
    }


}
