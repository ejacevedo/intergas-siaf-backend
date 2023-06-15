<?php

namespace App\Http\Livewire\User;

use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use App\Repositories\UserRepository;

use Livewire\Component;

class Create extends Component
{
    public $user;
    public $password = '';
    public $password_confirmation = '';
    public $roles;
    public $selected_roles;
    protected $userRepository;


    public function mount()
    {
        $this->userRepository = app(UserRepository::class);
        $this->user = $this->userRepository->newInstance();
        $this->roles = $this->userRepository->getAllRoles()->all();
    }

    protected function rules()
    {
        return [
            'user.name' => 'required|string',
            'user.username' => 'required|string',
            'password' => ['required', Password::defaults()],
            'password_confirmation' => 'required|same:password',
            'selected_roles' => 'required|array',
        ];
    }

    public function save()
    {
        $this->validate();
        $this->user->password = $this->password;
        $this->user->user_id = Auth::id();
        $this->user->save();

        $this->user->assignRole($this->selected_roles);

        return redirect()->route('users.index');
    }

    public function render()
    {
        return view('livewire.user.create');
    }
}
