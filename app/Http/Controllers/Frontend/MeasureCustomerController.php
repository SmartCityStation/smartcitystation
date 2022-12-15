<?php

namespace App\Http\Controllers\Frontend;

use App\Domains\Auth\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Backend\LocationDevice;
use App\Models\Backend\Project;
use App\Models\Backend\ProjectVariable;
use App\Models\Frontend\Measure;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class MeasureCustomerController extends Controller
{
    public function index()
    {
        $customer = auth()->id();
        $user = User::select('type')->where('id', $customer)->first();

        return view('frontend.measures.measure_customer', compact('user'));
    }
}
