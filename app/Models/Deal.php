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
 * @property int $passport_id
 * @property-read \App\Models\Contractor|null $contractor
 * @property-read \App\Models\Passport|null $passport
 * @method static \Illuminate\Database\Eloquent\Builder|Deal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Deal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Deal query()
 * @method static \Illuminate\Database\Eloquent\Builder|Deal whereContractorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deal whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deal whereDataJson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deal whereDealDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deal whereDealType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deal wherePassportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deal whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deal whereUpdatedBy($value)
 * @property-read \App\Models\LegalEntity|null $legalEntity
 * @property int $legal_entity_id
 * @method static \Illuminate\Database\Eloquent\Builder|Deal whereLegalEntityId($value)
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
		'legal_entity_id',
		'deal_date',
		'deal_type',
		'data_json',
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
    
    CONST LIST_LIMIT = 20;
	
	public function contractor()
	{
		return $this->hasOne(Contractor::class, 'id', 'contractor_id');
	}
	
	public function passport()
	{
		return $this->hasOne(Passport::class, 'id', 'passport_id');
	}
	
	public function legalEntity()
	{
		return $this->hasOne(LegalEntity::class, 'id', 'legal_entity_id');
	}
}
