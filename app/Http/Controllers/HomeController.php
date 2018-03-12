<?php

namespace App\Http\Controllers;

use App\Project;
use App\Registration;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	    $thisMonthRange = $this->getCurrentMonth();
	    $currentMonthLabel = Carbon::now()->formatLocalized('%B');
    	$customers = DB::table('customers')->where('user_id', auth()->user()->id)->get();
    	$projects = Project::orderBy('customer_id')->with('customer')->where('user_id', auth()->user()->id)->get();
    	$registrations = Registration::orderBy('workday', 'desc')->with(['project', 'customer'])->where('user_id', auth()->user()->id)->whereBetween('workday', $thisMonthRange)->get();
        return view('home', [
        	'customers' => $customers,
	        'projects' => $projects,
	        'registrations' => $registrations,
	        'currentMonth' => $currentMonthLabel]
        );
    }

    private function getCurrentMonth() {
    	$endOfMonth = Carbon::now()->endOfMonth();
    	$beginOfMonth = Carbon::now()->startOfMonth();

    	return [
    		$beginOfMonth,
		    $endOfMonth
	    ];
    }
}
