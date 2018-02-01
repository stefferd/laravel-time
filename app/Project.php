<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
	protected $fillable = ['user_id', 'name', 'project_id'];

	public function saveProject($data)
	{
		$this->user_id = auth()->user()->id;
		$this->name = $data['name'];
		$this->customer_id = $data['customer_id'];
		$this->save();
		return 1;
	}

	public function customer()
	{
		return $this->belongsTo(Customer::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
