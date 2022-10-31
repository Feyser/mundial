<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Ronda
 * 
 * @property int $id
 * @property string $nombre
 * 
 * @property Collection|Jornada[] $jornadas
 *
 * @package App\Models
 */
class Ronda extends Model
{
	protected $table = 'ronda';
	public $timestamps = false;

	protected $fillable = [
		'nombre'
	];

	public function jornadas()
	{
		return $this->hasMany(Jornada::class);
	}
}
