<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Clasificacion
 * 
 * @property int $id
 * @property int $pais_id
 * @property int $posicion
 * 
 * @property PaisesClasificado $paises_clasificado
 *
 * @package App\Models
 */
class Clasificacion extends Model
{
	protected $table = 'clasificacion';
	public $timestamps = false;

	protected $casts = [
		'pais_id' => 'int',
		'posicion' => 'int'
	];

	protected $fillable = [
		'pais_id',
		'posicion'
	];

	public function paises_clasificado()
	{
		return $this->belongsTo(PaisesClasificado::class, 'pais_id');
	}
}
