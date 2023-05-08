<?php

namespace App\Http\Livewire\User;
use App\Models\User;

use Livewire\Component;
use Livewire\WithPagination;

use Illuminate\Support\Facades\Auth;


class Index extends Component
{
    public function render()
    {
        $users = User::where('id', '<>',Auth::id()) 
        ->paginate(5);
        return view('livewire.user.index', compact('users'));
    }
}
