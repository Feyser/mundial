<?php

namespace App\Http\Controllers;

use App\Models\Apuesta;
use App\Models\Equipo;
use App\Models\Liga;
use App\Models\Mundial;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class LigaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ligas = Liga::all();

        return $ligas;
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
            'nombre' => 'required|string|max:200',
            'tipo' => 'required|string|max:4',
        ]);

        if ($validator->fails()) {
            return response()->json([$validator->errors()]);
        }

        $user = auth()->id();
        $usuario = Usuario::where('usuario', $user)->firstOrFail();

        if (intval($usuario['rol_id']) === 3) {
            return response()
                ->json(['message' => 'Unauthorized'], 401);
        }

        $mundial = Mundial::where('estado', 'A')->firstOrFail();
        $liga = Liga::create([
            'usuario_id' => $usuario['id'],
            'mundial_id' => $mundial['id'],
            'nombre' => $request->nombre,
            'fecha_registro' => Carbon::now(),
            'tipo' => $request->tipo,
            'estado' => 'A',
        ]);

        return response()
            ->json(['data' => $liga]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function equipo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'liga' => 'required|int|min:1',
            'nombre' => 'required|string|max:200',
        ]);

        if ($validator->fails()) {
            return response()->json([$validator->errors()]);
        }

        $user = auth()->id();
        $usuario = Usuario::where('usuario', $user)->firstOrFail();

        $equipo = Equipo::create([
            'liga_id' => $request->liga,
            'usuario_id' => $usuario['id'],
            'nombre' => $request->nombre
        ]);

        return response()
            ->json(['data' => $equipo]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function apuesta(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'liga' => 'required|int|min:1',
            'equipo' => 'required|int|min:1',
            'jornada' => 'required|int|min:1',
            'local' => 'required|int|min:1',
            'visitante' => 'required|int|min:1',
            'monto' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([$validator->errors()]);
        }

        $apuesta = Apuesta::create([
            'liga_id' => $request->liga,
            'equipo_id' => $request->equipo,
            'jornada_id' => $request->jornada,
            'local' => $request->local,
            'visitante' => $request->visitante,
            'monto' => $request->monto,
        ]);

        return response()
            ->json(['data' => $apuesta]);
    }
}
