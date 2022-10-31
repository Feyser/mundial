<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Equipo
 * 
 * @property int $id
 * @property int $liga_id
 * @property int $usuario_id
 * @property string $nombre
 * @property float|null $total_recaudado
 * 
 * @property Liga $liga
 * @property Usuario $usuario
 * @property Collection|Apuestum[] $apuesta
 * @property Collection|Invitacion[] $invitacions
 *
 * @package App\Models
 */
class Equipo extends Model
{
	protected $table = 'equipo';
	public $timestamps = false;

	protected $casts = [
		'liga_id' => 'int',
		'usuario_id' => 'int',
		'total_recaudado' => 'float'
	];

	protected $fillable = [
		'liga_id',
		'usuario_id',
		'nombre',
		'total_recaudado'
	];

	public function liga()
	{
		return $this->belongsTo(Liga::class);
	}

	public function usuario()
	{
		return $this->belongsTo(Usuario::class);
	}

	public function apuesta()
	{
		return $this->hasMany(Apuestum::class);
	}

	public function invitacions()
	{
		return $this->hasMany(Invitacion::class);
	}
}
