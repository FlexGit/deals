<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Passport
 *
 * @property int $id
 * @property int $contractor_id
 * @property string|null $series
 * @property string|null $number
 * @property \datetime|null $issue_date
 * @property string|null $issue_office
 * @property int $zipcode
 * @property string|null $region
 * @property string|null $city
 * @property string|null $street
 * @property string|null $house
 * @property string|null $apartment
 * @property array|null $data_json
 * @property int $created_by
 * @property int $updated_by
 * @property \datetime|null $created_at
 * @property \datetime|null $updated_at
 * @property-read \App\Models\Contractor|null $contractor
 * @property-read \App\Models\User|null $createdBy
 * @property-read \App\Models\User|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|Passport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Passport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Passport query()
 * @method static \Illuminate\Database\Eloquent\Builder|Passport whereApartment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Passport whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Passport whereContractorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Passport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Passport whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Passport whereDataJson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Passport whereHouse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Passport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Passport whereIssueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Passport whereIssueOffice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Passport whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Passport whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Passport whereSeries($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Passport whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Passport whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Passport whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Passport whereZipcode($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Deal[] $deals
 * @property-read int|null $deals_count
 */
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
		'apartment',
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
	
	public function deals()
	{
		return $this->hasMany(Deal::class, 'passport_id', 'id')
			->orderByDesc('id')
			->with(['createdBy', 'updatedBy']);
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
