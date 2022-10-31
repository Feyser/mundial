<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Apuestum
 * 
 * @property int $id
 * @property int $liga_id
 * @property int $equipo_id
 * @property int $jornada_id
 * @property int $local
 * @property int $visitante
 * @property float $monto
 * 
 * @property Equipo $equipo
 * @property Jornada $jornada
 * @property Liga $liga
 *
 * @package App\Models
 */
class Apuestum extends Model
{
	protected $table = 'apuesta';
	public $timestamps = false;

	protected $casts = [
		'liga_id' => 'int',
		'equipo_id' => 'int',
		'jornada_id' => 'int',
		'local' => 'int',
		'visitante' => 'int',
		'monto' => 'float'
	];

	protected $fillable = [
		'liga_id',
		'equipo_id',
		'jornada_id',
		'local',
		'visitante',
		'monto'
	];

	public function equipo()
	{
		return $this->belongsTo(Equipo::class);
	}

	public function jornada()
	{
		return $this->belongsTo(Jornada::class);
	}

	public function liga()
	{
		return $this->belongsTo(Liga::class);
	}
}
