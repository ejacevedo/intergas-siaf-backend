<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\User;

use Illuminate\Support\Facades\Auth;

use App\Repositories\UserRepository;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    // public $page = 2;
    // public $perPage = 2;
    // public $search = '';

    // protected $queryString = [
    //     'search' => ['except' => ''],
    //     'page' => ['except' => 10],
    //     // 'perPage' => ['except' => 10]
    // ];

    // protected $queryString = [
    //     'filter' => ['except' => ''],
    //     // 'filter_status' => ['except' => ''],
    //     'page' => ['except' => 1],
    // ];

    public $perPage = 1;
    public $filter = null;

    protected $queryString = [
        'filter' => ['except' => ''],
        'page' => ['except' => '1'],
    ];

    //  public User $users;
    // // public $payments;

    protected $userRepository;

    public function mount(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function resetPage()
    {
        $this->page = 1;
    }

    public function search()
    {
        $this->resetPage();

        $this->render();
    }

    // public function render()
    // {
        
    //     $users = $this->userRepository->getAll($this->page, null, [], [
    //         'name' => $this->search,
    //         'username' => $this->search,
    //     ]);

    //     return view('livewire.user.index', [
    //         'users' => $users
    //     ]);
    // }

    public function render()
    {        
        $users = User::where('id', '<>',Auth::id())->where(function($query) {
            $query->when($this->search !== '', function ($query) {
                $query->where('name', 'like', "%$this->search%")
                ->orWhere('username', 'like', "%$this->search%");
            });
        })
        ->with('roles')
        ->latest()
        ->paginate(5);
        return view('livewire.user.index', [
            'users' => $users
        ]);
    }
}
