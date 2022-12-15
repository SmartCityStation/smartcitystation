<?php

namespace App\Http\Livewire\Backend;

use App\Models\Backend\Project;
use Livewire\Component;

class ProjectTable extends Component
{

    public $search;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $projects = Project::select('projects.id', 'users.name as usName', 'projects.name as proName', 'projects.company')
        ->join('users', 'users.id', '=', 'projects.user_id')
        ->paginate(5);

        return view('livewire.backend.project-table', compact('projects'));
    }
}
