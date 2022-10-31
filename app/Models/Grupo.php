<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Grupo
 * 
 * @property int $id
 * @property string $nombre
 * 
 * @property Collection|Posicione[] $posiciones
 *
 * @package App\Models
 */
class Grupo extends Model
{
	protected $table = 'grupo';
	public $timestamps = false;

	protected $fillable = [
		'nombre'
	];

	public function posiciones()
	{
		return $this->hasMany(Posicione::class);
	}
}
