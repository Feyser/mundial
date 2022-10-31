<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:80',
            'email' => 'required|string|max:180',
            'password' => 'required|string|min:8',
            'rol' => 'required|int|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([$validator->errors()]);
        }

        if (!in_array($request->rol, [1, 2, 3])) {
            return response()->json(['message' => 'Rol invalid'], 401);
        }

        $user = User::create([
            'name'  => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        Usuario::create([
            'rol_id' => $request->rol,
            'usuario' => $user['id']
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json(['data' => $user, 'access_token' => $token, 'token_type' => 'Bearer']);
    }

    public function login(Request $request)
    {
        if(!Auth::attempt($request->only('email', 'password')))
        {
            return response()
                ->json(['message' => 'Unauthorized'], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json([
                'message' => 'Hi ' . $user->name,
                'accessToken' => $token,
                'token_type'  => 'Bearer',
                'user' => $user,
            ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'You have successfully logged out and the tokens was successfully deleted.'
        ];
    }
}
