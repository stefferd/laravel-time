<?php

namespace App\Http\Controllers;

use App\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
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
	    $customers = Customer::all();
	    $projects = Project::orderBy('customer_id')->with('customer')->get();
	    $registrations = Registration::orderBy('workday', 'desc')->with(['project', 'customer'])->get();
	    $editRegistration = Registration::get($id);
	    return view('home', ['customers' => $customers, 'projects' => $projects, 'registrations' => $registrations, 'editRegistration' => $editRegistration]);
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
        //
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
}
