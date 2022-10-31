<?php

namespace App\Http\Controllers;

use App\Models\Mundial;
use App\Models\PaisesClasificado;
use App\Models\Posiciones;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaisesController extends Controller
{
    /**
     * Display a listing of the resource paises.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mundial = Mundial::where('estado', 'A')->firstOrFail();
        $paises  = PaisesClasificado::where('mundial_id', $mundial['id']);

        return $paises;
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
            'pais' => 'required|int|min:1',
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
        $pais = PaisesClasificado::create([
            'pais_id' => $request->sede,
            'mundial_id' => $mundial['id'],
            'participacion' => 'A'
        ]);

        return response()
            ->json(['data' => $pais]);
    }

    public function grupo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pais' => 'required|int|min:1',
            'grupo' => 'required|int|min:1',
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
        $pais = PaisesClasificado::where('pais_id', $request->pais)->where('mundial_id', $mundial['id']);

        if (!$pais) {
            return response()->json(['message' => 'Pais No Clasificado'], 401);
        }

        $grupo = Posiciones::create([
            'mundial_id' => $mundial['id'],
            'grupo_id' => $request->grupo,
            'pais_id' => $request->pais
        ]);

        return response()
            ->json(['data' => $grupo]);
    }
}
