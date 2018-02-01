<?php

namespace App\Http\Controllers;

use App\Project;
use App\Registration;
use Illuminate\Http\Request;
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
    	$customers = DB::table('customers')->get();
    	$projects = Project::orderBy('customer_id')->with('customer')->get();
    	$registrations = Registration::orderBy('workday', 'desc')->with(['project', 'customer'])->get();
        return view('home', ['customers' => $customers, 'projects' => $projects, 'registrations' => $registrations]);
    }
}
