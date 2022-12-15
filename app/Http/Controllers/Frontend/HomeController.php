<?php

namespace App\Http\Controllers\Frontend;

use App\Domains\Auth\Models\User;

/**
 * Class HomeController.
 */
class HomeController
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $customer = auth()->id();
        $user = User::select('type')->where('id', $customer)->first();

        return view('frontend.index',compact('user'));
    }
}
