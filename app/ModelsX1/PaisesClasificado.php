<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PaisesClasificado
 * 
 * @property int $id
 * @property int $pais_id
 * @property int $mundial_id
 * @property string $participacion
 * 
 * @property Mundial $mundial
 * @property Pai $pai
 * @property Clasificacion $clasificacion
 * @property Collection|Jornada[] $jornadas
 * @property Posicione $posicione
 *
 * @package App\Models
 */
class PaisesClasificado extends Model
{
	protected $table = 'paises_clasificados';
	public $timestamps = false;

	protected $casts = [
		'pais_id' => 'int',
		'mundial_id' => 'int'
	];

	protected $fillable = [
		'pais_id',
		'mundial_id',
		'participacion'
	];

	public function mundial()
	{
		return $this->belongsTo(Mundial::class);
	}

	public function pai()
	{
		return $this->belongsTo(Pai::class, 'pais_id');
	}

	public function clasificacion()
	{
		return $this->hasOne(Clasificacion::class, 'pais_id');
	}

	public function jornadas()
	{
		return $this->hasMany(Jornada::class, 'visitante_id');
	}

	public function posicione()
	{
		return $this->hasOne(Posicione::class, 'pais_id');
	}
}
