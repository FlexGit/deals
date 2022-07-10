<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Inspection
 *
 * @property int $id
 * @property int $contractor_id
 * @property array $data_json
 * @property \Carbon\Carbon $deal_date
 * @property string $deal_type
 * @property int $created_by
 * @property int $updated_by
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @mixin \Eloquent
 */

class Deal extends Model {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'contractor_id',
		'passport_id',
        'data_json',
		'deal_date',
		'deal_type',
		'created_by',
		'updated_by',
    ];
    
    protected $dates = [
    	'created_at',
		'updated_at',
		'deal_date',
	];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
		'deal_date' => 'datetime:Y-m-d H:i:s',
		'created_at' => 'datetime:Y-m-d H:i:s',
		'updated_at' => 'datetime:Y-m-d H:i:s',
		'data_json' => 'array',
    ];
	
	public function contractor()
	{
		return $this->hasOne(Contractor::class, 'id', 'contractor_id');
	}
	
	public function passport()
	{
		return $this->hasOne(Passport::class, 'id', 'passport_id');
	}
}
