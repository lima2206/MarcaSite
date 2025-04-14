<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'usu_email' => 'required|email',
            'usu_senha' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Dados inválidos'], 400);
        }

        $user = Usuario::where('usu_email', $request->usu_email)->first();

        if (!$user || !Hash::check($request->usu_senha, $user->usu_senha)) {
            return response()->json(['message' => 'Email ou senha incorretos'], 401);
        }

        return response()->json($user);
    }
}
