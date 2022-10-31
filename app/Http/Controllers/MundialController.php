<?php

namespace App\Http\Controllers;

use App\Models\Ciudad;
use App\Models\Estadio;
use App\Models\Mundial;
use App\Models\Pais;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MundialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ligas = Mundial::all();

        return $ligas;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function pais(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:150'
        ]);

        if ($validator->fails()) {
            return response()->json([$validator->errors()]);
        }

        $pais = Pais::create([
            'nombre' => $request->nombre
        ]);

        return response()
            ->json(['data' => $pais]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ciudad(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pais' => 'required|int|min:1',
            'nombre' => 'required|string|max:150'
        ]);

        if ($validator->fails()) {
            return response()->json([$validator->errors()]);
        }

        $ciudad = Ciudad::create([
            'pais_id' => $request->pais,
            'nombre' => $request->nombre
        ]);

        return response()
            ->json(['data' => $ciudad]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function estadio(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ciudad' => 'required|int|max:1',
            'nombre' => 'required|string|max:150'
        ]);

        if ($validator->fails()) {
            return response()->json([$validator->errors()]);
        }

        $pais = Estadio::create([
            'ciudad_id' => $request->ciudad,
            'nombre' => $request->nombre
        ]);

        return response()
            ->json(['data' => $pais]);
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
            'sede' => 'required|int|min:1',
            'descripcion' => 'required|string|max:250'
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

        $mundial = Mundial::create([
            'sede_id' => $request->sede,
            'fecha_inicio' => Carbon::now(),
            'descripcion' => $request->descripcion,
            'estado' => 'A'
        ]);

        return response()
            ->json(['data' => $mundial]);
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
            'sede' => 'required|int|min:1',
            'descripcion' => 'required|string|max:250'
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

        $sede = Mundial::find($id);
        $sede->sede_id = $request->sede;
        $sede->descripcion = $request->descripcion;
        $sede->update();

        return response()
            ->json(['message' => 'Sede actualizada']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function finalizar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sede' => 'required|int|min:1',
            'descripcion' => 'required|string|max:250'
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
        DB::select("exec sp_fin_apuesta(?)", array($mundial['id']));

        return response()
            ->json(['data' => $mundial]);
    }
}
