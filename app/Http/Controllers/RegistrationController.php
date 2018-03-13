<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Project;
use App\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class RegistrationController extends Controller
{
	private $currentMonth = null;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
	    $registration = new Registration();
	    $data = $this->validate($request, [
		    'workday'=>'required',
		    'amount'=> 'required',
		    'description' => 'required',
		    'customer_id' => 'required',
		    'project_id' => 'required'
	    ]);

	    $registration->saveRegistration($data);
	    return redirect('/home')->with('success', 'Tijd registratie is toegevoegd!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    	//
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
	    $subMonth = Carbon::now()->month;
	    $subYear = Carbon::now()->year;
	    $this->getCurrentMonth($subMonth, $subYear);
	    $thisMonthRange = $this->getCurrentRange();
	    $currentMonthLabel = $this->currentMonth->formatLocalized('%B');
	    $customers = Customer::all();
	    $projects = Project::orderBy('customer_id')->with('customer')->get();
	    $registrations = Registration::orderBy('workday', 'desc')->with(['project', 'customer'])->get();
	    $editRegistration = Registration::find($id);
	    return view('home', ['customers' => $customers, 'projects' => $projects, 'registrations' => $registrations, 'editRegistration' => $editRegistration,'currentMonth' => $currentMonthLabel,
	                         'subMonth' => $subMonth,
	                         'subYear' => $subYear]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
	    $registration = Registration::find($id);
	    $this->validate($request, [
		    'workday'=>'required',
		    'amount'=> 'required',
		    'description' => 'required',
		    'customer_id' => 'required',
		    'project_id' => 'required'
	    ]);
	    $registration->workday = $request->input('workday');
	    $registration->amount = $request->input('amount');
	    $registration->description = $request->input('description');
	    $registration->customer_id = $request->input('customer_id');
	    $registration->project_id = $request->input('project_id');
	    $registration->save();
	    return redirect('/home')->with('success', 'Tijd registratie is aangepast!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Registration::destroy($id);
	    return redirect('/home')->with('success', 'Tijd registratie is verwijderd!');
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
