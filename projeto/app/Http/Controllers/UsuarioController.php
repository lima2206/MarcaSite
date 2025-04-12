<?php

namespace App\Http\Controllers;

use App\Services\UsuarioService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{
    protected $usuarioService;

    public function __construct(UsuarioService $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }

    public function index()
    {
        $usuarios = $this->usuarioService->getAllUsuarios();
        return response()->json($usuarios);
    }

    public function show($id)
    {
        $usuario = $this->usuarioService->getUsuarioById($id);
        return response()->json($usuario);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'usu_email' => 'required|email|unique:usu_usuario,usu_email',
            'usu_senha' => 'required|min:6',
            'usu_is_adm' => 'boolean',
            'usu_cpf' => 'nullable|string',
            'usu_endereco' => 'nullable|string',
            'usu_empresa' => 'nullable|string',
            'usu_telefone' => 'nullable|string',
            'usu_celular' => 'nullable|string',
            'usu_tipo' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $usuario = $this->usuarioService->createUsuario($request->all());
        return response()->json($usuario, 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'usu_email' => "email|unique:usu_usuario,usu_email,{$id},usu_id",
            'usu_senha' => 'nullable|min:6',
            'usu_is_adm' => 'boolean',
            'usu_cpf' => 'nullable|string',
            'usu_endereco' => 'nullable|string',
            'usu_empresa' => 'nullable|string',
            'usu_telefone' => 'nullable|string',
            'usu_celular' => 'nullable|string',
            'usu_tipo' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422, );
        }

        $usuario = $this->usuarioService->updateUsuario($id, $request->all());
        return response()->json($usuario);
    }

    public function destroy($id)
    {
        $this->usuarioService->deleteUsuario($id);
        return response()->json(null, 204);
    }
}