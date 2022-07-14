<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Contractor
 *
 * @property int $id
 * @property string $name
 * @property array $data_json
 * @property int $created_by
 * @property int $updated_by
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Passport[] $passports
 * @property-read int|null $passports_count
 * @method static \Illuminate\Database\Eloquent\Builder|Contractor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contractor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contractor query()
 * @method static \Illuminate\Database\Eloquent\Builder|Contractor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contractor whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contractor whereDataJson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contractor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contractor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contractor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contractor whereUpdatedBy($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Deal[] $deals
 * @property-read int|null $deals_count
 */

class Contractor extends Model {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'data_json',
		'created_by',
		'updated_by',
    ];
	
	protected $dates = [
		'created_at',
		'updated_at',
	];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
		'created_at' => 'datetime:Y-m-d H:i:s',
		'updated_at' => 'datetime:Y-m-d H:i:s',
		'data_json' => 'array',
    ];
	
	CONST LIST_LIMIT = 20;
	
	public static function boot() {
		parent::boot();
		
		Contractor::deleting(function(Contractor $contractor) {
			$contractor->passports()->delete();
		});
	}
	
	public function passports()
	{
		return $this->hasMany(Passport::class, 'contractor_id', 'id')
			->orderByDesc('id')
			->with(['createdBy', 'updatedBy']);
	}
	
	public function deals()
	{
		return $this->hasMany(Deal::class, 'contractor_id', 'id')
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
