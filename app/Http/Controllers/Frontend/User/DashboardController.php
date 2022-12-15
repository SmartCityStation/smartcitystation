<?php

namespace App\Http\Controllers\Frontend\User;

use App\Domains\Auth\Models\User;

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
        $customer = auth()->id();
        $user = User::select('type')->where('id', $customer)->first();

        return view('frontend.measures.measure_visitor', compact('user'));
        // return view('frontend.user.dashboard');
    }
}
