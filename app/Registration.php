<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Registration extends Model
{

	protected $fillable = ['user_id', 'customer_id', 'project_id', 'workday', 'amount', 'description'];

	public function saveRegistration($data)
	{
		$this->user_id = auth()->user()->id;
		$this->workday = $data['workday'];
		$this->amount = $data['amount'];
		$this->description = $data['description'];
		$this->customer_id = $data['customer_id'];
		$this->project_id = $data['project_id'];
		$this->save();
		return 1;
	}

	public function getWorkdayAttribute($value) {
		return Carbon::parse($value)->formatLocalized('%d-%m-%Y');
	}

	public function customer()
	{
		return $this->belongsTo(Customer::class);
	}

	public function project()
	{
		return $this->belongsTo(Project::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
