<?php

namespace App\Http\Livewire;

use App\Domains\Auth\Models\User as ModelsUser;
use App\Domains\Auth\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserTable extends Component
{

    use WithPagination;

    public $search;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function assignRole(User $user, $value)
    {
        if ($value == '1') {
            $user->assignRole('Customer');
            // Hacer un update sobre la tabla users, cambiando el "Type" a cliente
            $user->update(['type' => User::TYPE_CUSTOMER]);
        } else {
            $user->removeRole('Customer');
            // Hacer un update sobre la tabla users, cambiando el "Type" a visitante
            $user->update(['type' => user::TYPE_USER]);
        }
    }

    public function render()
    {
        $users = ModelsUser::where('email', '<>', auth()->user()->email)
            ->where(function ($query) {
                $query->where('name', 'LIKE', '%' . $this->search . '%');
                $query->orwhere('email', 'LIKE', '%' . $this->search . '%');
            })->paginate();

        return view('livewire.user-table', compact('users'));
    }
}
