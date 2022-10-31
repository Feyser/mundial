<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Posicione
 * 
 * @property int $id
 * @property int $mundial_id
 * @property int $grupo_id
 * @property int $pais_id
 * @property int|null $partidos
 * @property int|null $ganados
 * @property int|null $empatados
 * @property int|null $perdidos
 * @property int|null $goles_favor
 * @property int|null $goles_contra
 * @property int|null $puntos
 * 
 * @property Grupo $grupo
 * @property Mundial $mundial
 * @property PaisesClasificado $paises_clasificado
 *
 * @package App\Models
 */
class Posiciones extends Model
{
	protected $table = 'posiciones';
	public $timestamps = false;

	protected $casts = [
		'mundial_id' => 'int',
		'grupo_id' => 'int',
		'pais_id' => 'int',
		'partidos' => 'int',
		'ganados' => 'int',
		'empatados' => 'int',
		'perdidos' => 'int',
		'goles_favor' => 'int',
		'goles_contra' => 'int',
		'puntos' => 'int'
	];

	protected $fillable = [
		'mundial_id',
		'grupo_id',
		'pais_id',
		'partidos',
		'ganados',
		'empatados',
		'perdidos',
		'goles_favor',
		'goles_contra',
		'puntos'
	];

	public function grupo()
	{
		return $this->belongsTo(Grupo::class);
	}

	public function mundial()
	{
		return $this->belongsTo(Mundial::class);
	}

	public function paises_clasificado()
	{
		return $this->belongsTo(PaisesClasificado::class, 'pais_id');
	}
}
