<?php

namespace App\Http\Controllers\Backend;

use App\Models\Backend\Project;

/**
 * Class DashboardController.
 */
class DashboardController
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {

        $events = Project::select('name as title', 'start_date as start', 'end_date as end')->get()->toArray();  

        return view('backend.dashboard')->with('events', $events);
    }
}
