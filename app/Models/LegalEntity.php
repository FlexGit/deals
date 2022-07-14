<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LegalEntity
 *
 * @method static \Illuminate\Database\Eloquent\Builder|LegalEntity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LegalEntity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LegalEntity query()
 * @mixin \Eloquent
 * @property int $id
 * @property string|null $name
 * @property string|null $inn
 * @property string|null $kpp
 * @property string|null $ogrn
 * @property string|null $bank
 * @property string|null $rs
 * @property string|null $ks
 * @property string|null $bik
 * @property string|null $address
 * @property int $created_by
 * @property int $updated_by
 * @property \datetime|null $created_at
 * @property \datetime|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|LegalEntity whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegalEntity whereBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegalEntity whereBik($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegalEntity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegalEntity whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegalEntity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegalEntity whereInn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegalEntity whereKpp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegalEntity whereKs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegalEntity whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegalEntity whereOgrn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegalEntity whereRs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegalEntity whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LegalEntity whereUpdatedBy($value)
 */
class LegalEntity extends Model {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
		'inn',
		'kpp',
		'ogrn',
		'bank',
		'rs',
		'ks',
		'bik',
		'address',
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
    ];
}
