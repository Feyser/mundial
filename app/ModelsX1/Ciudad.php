<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Ciudad
 * 
 * @property int $id
 * @property int $pais_id
 * @property string $nombre
 * 
 * @property Pai $pai
 * @property Collection|Estadio[] $estadios
 *
 * @package App\Models
 */
class Ciudad extends Model
{
	protected $table = 'ciudad';
	public $timestamps = false;

	protected $casts = [
		'pais_id' => 'int'
	];

	protected $fillable = [
		'pais_id',
		'nombre'
	];

	public function pai()
	{
		return $this->belongsTo(Pai::class, 'pais_id');
	}

	public function estadios()
	{
		return $this->hasMany(Estadio::class);
	}
}
