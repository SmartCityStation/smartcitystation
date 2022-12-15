<?php

namespace App\Http\Controllers\Frontend\User;

use App\Domains\Auth\Models\User;

/**
 * Class AccountController.
 */
class AccountController
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $customer = auth()->id();
        $user = User::select('type')->where('id', $customer)->first();

        return view('frontend.user.account', compact('user'));
    }
}
