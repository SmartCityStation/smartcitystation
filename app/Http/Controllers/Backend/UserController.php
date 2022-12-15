<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;

class UserController extends AppBaseController
{
    public function index()
    {
        return view('backend.users.index');
    }
}
