<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Passport extends Model {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'contractor_id',
		'series',
		'number',
		'issue_date',
		'issue_office',
		'zipcode',
		'region',
		'city',
		'street',
		'house',
		'appartment',
        'data_json',
		'created_by',
		'updated_by',
    ];
	
	protected $dates = [
		'created_at',
		'updated_at',
		'issue_date',
	];
	
	/**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
		'created_at' => 'datetime:Y-m-d H:i:s',
		'updated_at' => 'datetime:Y-m-d H:i:s',
		'issue_date' => 'datetime:Y-m-d',
		'data_json' => 'array',
    ];
	
	public function contractor()
	{
		return $this->hasOne(Contractor::class, 'id', 'contractor_id');
	}
	
	public function createdBy()
	{
		return $this->hasOne(User::class, 'id', 'created_by');
	}
	
	public function updatedBy()
	{
		return $this->hasOne(User::class, 'id', 'updated_by');
	}
}
