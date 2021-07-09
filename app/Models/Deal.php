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
		'data_json' => 'array',
    ];
	
	public function contractor() {
		return $this->hasOne('App\Models\Contractor', 'id', 'contractor_id');
	}
	
}
