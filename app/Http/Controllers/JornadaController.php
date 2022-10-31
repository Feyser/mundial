<?php

namespace App\Http\Controllers;

use App\Models\Jornada;
use App\Models\Mundial;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use \stdClass;

class JornadaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mundial  = Mundial::where('estado', 'A')->firstOrFail();
        $jornadas = Jornada::where('mundial_id', $mundial['id']);

        return $jornadas;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'estadio' => 'required|int|min:1',
            'ronda' => 'required|int|min:1',
            'local' => 'required|int|min:1',
            'visitante' => 'required|int|min:1',
            'fecha' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([$validator->errors()]);
        }

        $user = auth()->id();
        $usuario = Usuario::where('usuario', $user)->firstOrFail();
        if (intval($usuario['rol_id']) !== 1) {
            return response()
                ->json(['message' => 'Unauthorized'], 401);
        }

        $mundial = Mundial::where('estado', 'A')->firstOrFail();
        $pais = Jornada::create([
            'estadio_id' => $request->estadio,
            'local_id' => $mundial['id'],
            'visitante_id' => $request->visitante,
            'mundial_id' => $mundial['id'],
            'ronda_id' => $request->ronda,
            'fecha' => Carbon::now()
        ]);

        return response()
            ->json(['data' => $pais]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mundial  $mundial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'local'     => 'required|int|min:1',
            'visitante' => 'required|int|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([$validator->errors()]);
        }

        $user = auth()->id();
        $usuario = Usuario::where('usuario', $user)->firstOrFail();
        if (intval($usuario['rol_id']) !== 1) {
            return response()
                ->json(['message' => 'Unauthorized'], 401);
        }

        $sede = Jornada::find($id);
        $sede->marcador_local = $request->local;
        $sede->marcador_visitante = $request->visitante;
        $sede->update();

        $mundial = Mundial::where('estado', 'A')->firstOrFail();
        //DB::select("exec sp_upd_apuesta(?,?,?,?)", array($mundial['id'], $id, $request->local, $request->visitante));
        DB::select("call sp_upd_apuesta({$mundial['id']},{$id},{$request->local},{$request->visitante})");
        return response()
            ->json(['message' => 'Resultados actualizados']);
    }
}
