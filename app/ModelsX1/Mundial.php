<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Mundial
 * 
 * @property int $id
 * @property int $sede_id
 * @property Carbon $fecha_inicio
 * @property Carbon $fecha_fin
 * @property string|null $descripcion
 * @property string $estado
 * 
 * @property Pai $pai
 * @property Collection|Jornada[] $jornadas
 * @property Collection|Liga[] $ligas
 * @property Collection|PaisesClasificado[] $paises_clasificados
 * @property Collection|Posicione[] $posiciones
 *
 * @package App\Models
 */
class Mundial extends Model
{
	protected $table = 'mundial';
	public $timestamps = false;

	protected $casts = [
		'sede_id' => 'int'
	];

	protected $dates = [
		'fecha_inicio',
		'fecha_fin'
	];

	protected $fillable = [
		'sede_id',
		'fecha_inicio',
		'fecha_fin',
		'descripcion',
		'estado'
	];

	public function pai()
	{
		return $this->belongsTo(Pai::class, 'sede_id');
	}

	public function jornadas()
	{
		return $this->hasMany(Jornada::class);
	}

	public function ligas()
	{
		return $this->hasMany(Liga::class);
	}

	public function paises_clasificados()
	{
		return $this->hasMany(PaisesClasificado::class);
	}

	public function posiciones()
	{
		return $this->hasMany(Posicione::class);
	}
}
