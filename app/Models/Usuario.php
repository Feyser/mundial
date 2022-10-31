<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Usuario
 * 
 * @property int $id
 * @property int $rol_id
 * @property int $usuario
 * 
 * @property Rol $rol
 * @property User $user
 * @property Collection|Equipo[] $equipos
 * @property Collection|Liga[] $ligas
 *
 * @package App\Models
 */
class Usuario extends Model
{
	protected $table = 'usuario';
	public $timestamps = false;

	protected $casts = [
		'rol_id' => 'int',
		'usuario' => 'int'
	];

	protected $fillable = [
		'rol_id',
		'usuario',
	];

	public function rol()
	{
		return $this->belongsTo(Rol::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'usuario');
	}

	public function equipos()
	{
		return $this->hasMany(Equipo::class);
	}

	public function ligas()
	{
		return $this->hasMany(Liga::class);
	}
}
