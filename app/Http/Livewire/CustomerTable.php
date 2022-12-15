<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Domains\Auth\Models\User;

class CustomerTable extends Component
{
    use WithPagination;

    public $search;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $customers = User::where('email', '<>', auth()->user()->email)
            ->where(function ($query) {
                $query->where('name', 'LIKE', '%' . $this->search . '%');
                $query->orwhere('email', 'LIKE', '%' . $this->search . '%');
            })
            ->where('type', '=', 'customer')->paginate();

        return view('livewire.customer-table', compact('customers'));
    }
}
