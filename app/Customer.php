<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
	protected $fillable = ['user_id', 'name', 'contact', 'email', 'phone'];

	public function saveCustomer($data)
	{
		$this->user_id = auth()->user()->id;
		$this->name = $data['name'];
		$this->contact = $data['contact'];
		$this->email = $data['email'];
		$this->phone = $data['phone'];
		$this->save();
		return 1;
	}

	public function projects()
	{
		return $this->hasMany(Project::class);
	}
}
