<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Estadio
 * 
 * @property int $id
 * @property int $ciudad_id
 * @property string $nombre
 * 
 * @property Ciudad $ciudad
 * @property Collection|Jornada[] $jornadas
 *
 * @package App\Models
 */
class Estadio extends Model
{
	protected $table = 'estadio';
	public $timestamps = false;

	protected $casts = [
		'ciudad_id' => 'int'
	];

	protected $fillable = [
		'ciudad_id',
		'nombre'
	];

	public function ciudad()
	{
		return $this->belongsTo(Ciudad::class);
	}

	public function jornadas()
	{
		return $this->hasMany(Jornada::class);
	}
}
