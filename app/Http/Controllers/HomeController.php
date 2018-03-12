<?php

namespace App\Http\Controllers;

use App\Project;
use App\Registration;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
	private $currentMonth = null;
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
     * @params $currentMonth null by default
     *
     * @return \Illuminate\Http\Response
     */
    public function index($subMonth = null, $subYear = null)
    {
    	if ($subMonth == null) {
		    $subMonth = Carbon::now()->month;
	    }
	    if ($subYear == null) {
    		$subYear = Carbon::now()->year;
	    }
    	$this->getCurrentMonth($subMonth, $subYear);
	    $thisMonthRange = $this->getCurrentRange();
	    $currentMonthLabel = $this->currentMonth->formatLocalized('%B');
    	$customers = DB::table('customers')->where('user_id', auth()->user()->id)->get();
    	$projects = Project::orderBy('customer_id')->with('customer')->where('user_id', auth()->user()->id)->get();
    	$registrations = Registration::orderBy('workday', 'desc')->with(['project', 'customer'])->where('user_id', auth()->user()->id)->whereBetween('workday', $thisMonthRange)->get();
        return view('home', [
	            'customers' => $customers,
		        'projects' => $projects,
		        'registrations' => $registrations,
		        'currentMonth' => $currentMonthLabel,
		        'subMonth' => $subMonth,
		        'subYear' => $subYear

	        ]
        );
    }

    private function getCurrentRange() {
    	$endOfMonth = Carbon::parse($this->currentMonth)->endOfMonth();
    	$beginOfMonth = Carbon::parse($this->currentMonth)->startOfMonth();

    	return [
    		$beginOfMonth,
		    $endOfMonth
	    ];
    }

    private function getCurrentMonth($subMonth, $subYear) {
	    $this->currentMonth = Carbon::now();
	    if ($subMonth != null) {
		    $this->currentMonth->month(intval($subMonth));
	    }
	    if ($subYear != null) {
		    $this->currentMonth->year(intval($subYear));
	    }
    }
}
