<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use Livewire\WithPagination;

use App\Repositories\UserRepository;

class Index extends Component
{
    use WithPagination;

    protected $userRepository;
    public $perPage = 5;
    public $page = 1;
    public $filter = null;

    protected $queryString = [
        'filter' => ['except' => ''],
        'page' => ['except' => '1'],
        'perPage' => ['except' => '5']
    ];

    public function resetPage()
    {
        $this->page = 1;
        $this->render();
    }

    public function search()
    {
        $this->resetPage();
    }
    
    public function render()
    {
        $this->userRepository = app(UserRepository::class);
        $users = $this->userRepository->getAll($this->perPage, [
            'like' => [
                'name' => $this->filter,
                'username' => $this->filter
            ]
        ]);

        return view('livewire.user.index', [
            'users' => $users
        ]);
    }
}
