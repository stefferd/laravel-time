<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::resources([
	'customers' => 'CustomerController',
	'projects' => 'ProjectController',
	'registrations' => 'RegistrationController'
]);

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home/{currentMonth}/{currentYear}', 'HomeController@index')->name('homeMonthSwitched');