<?php

namespace App\Http\Livewire\User;

use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;
use App\Repositories\UserRepository;

use Livewire\Component;

class Edit extends Component
{
    public $user;
    public string $name;
    public string $username;
    public string $status;
    public string $password = '';
    public string $password_confirmation = '';
    public string $asda = '';
    public $roles;
    public $selected_roles;
    protected $userRepository;

    protected $rules = [
        'name' => 'required|string',
        'username' => 'required|string',
        'selected_roles' => 'required|array',
    ];

    public function mount($id)
    {
        $this->userRepository = app(UserRepository::class);
        $this->user = $this->userRepository->getById($id);
        $this->roles = $this->userRepository->getAllRoles()->all();
        $this->name = $this->user->name;
        $this->username = $this->user->username;
        $this->selected_roles = $this->user->getRoleNames();
        $this->status = $this->user->status ? "true" : "false";
    }

    public function render()
    {
        return view('livewire.user.edit');
    }

    public function save()
    {
        $this->validate();

        $this->user->name = $this->name;
        $this->user->username = $this->username;
        $this->user->status = $this->status == "true" ? true : false;

        if ($this->password || $this->password_confirmation) {

            $input = [
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
            ];

            $validator = Validator::make($input, [
                'password' => ['required', Password::defaults()],
                'password_confirmation' => 'required|same:password'
            ]);

            $validator->safe()->only(['password_confirmation', 'password']);
            $this->user->password = $this->password;
        }

        $this->user->save();
        $this->user->syncRoles($this->selected_roles);

        return redirect()->route('users.index');
    }


    public function getSelected($status)
    {
        return  $status ? 'selected' : '';
    }
}
