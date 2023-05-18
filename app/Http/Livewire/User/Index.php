<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\User;

use Illuminate\Support\Facades\Auth;


class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {        
        $users = User::where('id', '<>',Auth::id())->where(function($query) {
            $query->when($this->search !== '', function ($query) {
                $query->where('name', 'like', "%$this->search%")
                ->orWhere('username', 'like', "%$this->search%");
            });
        })
        // ->with('role')
        ->latest()
        ->paginate(5);
        return view('livewire.user.shows', [
            'users' => $users
        ]);
    }
}
