<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Coin
 *
 * @property int $id
 * @property string $name
 * @property array $data_json
 * @property int $created_by
 * @property int $updated_by
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|Coin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Coin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Coin query()
 * @method static \Illuminate\Database\Eloquent\Builder|Coin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coin whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coin whereDataJson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coin whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coin whereUpdatedBy($value)
 */

class Coin extends Model {
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
	
	CONST LIST_LIMIT = 20;
	
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
}
