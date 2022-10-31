<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Liga
 * 
 * @property int $id
 * @property int $usuario_id
 * @property int $mundial_id
 * @property string $nombre
 * @property Carbon $fecha_registro
 * @property string $tipo
 * @property string $estado
 * @property float|null $total_recaudado
 * @property float|null $ganancia
 * 
 * @property Mundial $mundial
 * @property Usuario $usuario
 * @property Collection|Apuestum[] $apuesta
 * @property Collection|Equipo[] $equipos
 * @property Collection|Invitacion[] $invitacions
 *
 * @package App\Models
 */
class Liga extends Model
{
	protected $table = 'liga';
	public $timestamps = false;

	protected $casts = [
		'usuario_id' => 'int',
		'mundial_id' => 'int',
		'total_recaudado' => 'float',
		'ganancia' => 'float'
	];

	protected $dates = [
		'fecha_registro'
	];

	protected $fillable = [
		'usuario_id',
		'mundial_id',
		'nombre',
		'fecha_registro',
		'tipo',
		'estado',
		'total_recaudado',
		'ganancia'
	];

	public function mundial()
	{
		return $this->belongsTo(Mundial::class);
	}

	public function usuario()
	{
		return $this->belongsTo(Usuario::class);
	}

	public function apuesta()
	{
		return $this->hasMany(Apuestum::class);
	}

	public function equipos()
	{
		return $this->hasMany(Equipo::class);
	}

	public function invitacions()
	{
		return $this->hasMany(Invitacion::class);
	}
}
