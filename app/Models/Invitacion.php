<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Invitacion
 * 
 * @property int $id
 * @property int $liga_id
 * @property int $equipo_id
 * @property string|null $token
 * @property string|null $estado
 * 
 * @property Equipo $equipo
 * @property Liga $liga
 *
 * @package App\Models
 */
class Invitacion extends Model
{
	protected $table = 'invitacion';
	public $timestamps = false;

	protected $casts = [
		'liga_id' => 'int',
		'equipo_id' => 'int'
	];

	protected $hidden = [
		'token'
	];

	protected $fillable = [
		'liga_id',
		'equipo_id',
		'token',
		'estado'
	];

	public function equipo()
	{
		return $this->belongsTo(Equipo::class);
	}

	public function liga()
	{
		return $this->belongsTo(Liga::class);
	}
}
