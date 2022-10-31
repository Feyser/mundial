<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Pai
 * 
 * @property int $id
 * @property string $nombre
 * 
 * @property Collection|Ciudad[] $ciudads
 * @property Collection|Mundial[] $mundials
 * @property Collection|PaisesClasificado[] $paises_clasificados
 *
 * @package App\Models
 */
class Pai extends Model
{
	protected $table = 'pais';
	public $timestamps = false;

	protected $fillable = [
		'nombre'
	];

	public function ciudads()
	{
		return $this->hasMany(Ciudad::class, 'pais_id');
	}

	public function mundials()
	{
		return $this->hasMany(Mundial::class, 'sede_id');
	}

	public function paises_clasificados()
	{
		return $this->hasMany(PaisesClasificado::class, 'pais_id');
	}
}
