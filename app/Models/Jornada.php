<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Jornada
 * 
 * @property int $id
 * @property int $estadio_id
 * @property int $local_id
 * @property int $visitante_id
 * @property int $mundial_id
 * @property int $ronda_id
 * @property int|null $marcador_local
 * @property int|null $marcador_visitante
 * @property Carbon $fecha
 * 
 * @property PaisesClasificado $paises_clasificado
 * @property Mundial $mundial
 * @property Ronda $ronda
 * @property Estadio $estadio
 * @property Collection|Apuestum[] $apuesta
 *
 * @package App\Models
 */
class Jornada extends Model
{
	protected $table = 'jornada';
	public $timestamps = false;

	protected $casts = [
		'estadio_id' => 'int',
		'local_id' => 'int',
		'visitante_id' => 'int',
		'mundial_id' => 'int',
		'ronda_id' => 'int',
		'marcador_local' => 'int',
		'marcador_visitante' => 'int'
	];

	protected $dates = [
		'fecha'
	];

	protected $fillable = [
		'estadio_id',
		'local_id',
		'visitante_id',
		'mundial_id',
		'ronda_id',
		'marcador_local',
		'marcador_visitante',
		'fecha'
	];

	public function paises_clasificado()
	{
		return $this->belongsTo(PaisesClasificado::class, 'visitante_id');
	}

	public function mundial()
	{
		return $this->belongsTo(Mundial::class);
	}

	public function ronda()
	{
		return $this->belongsTo(Ronda::class);
	}

	public function estadio()
	{
		return $this->belongsTo(Estadio::class);
	}

	public function apuesta()
	{
		return $this->hasMany(Apuestum::class);
	}
}
