<?php

namespace App\Services;

use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuarioService
{
    public function getAllUsuarios()
    {
        return Usuario::all();
    }

    public function getUsuarioById($id)
    {
        return Usuario::findOrFail($id);
    }

    public function createUsuario(array $data)
    {
        $data['usu_senha'] = Hash::make($data['usu_senha']);
        return Usuario::create($data);
    }

    public function updateUsuario($id, array $data)
    {
        $usuario = Usuario::findOrFail($id);
        
        // Only hash the password if it's being updated
        if (isset($data['usu_senha'])) {
            $data['usu_senha'] = Hash::make($data['usu_senha']);
        }
        
        $usuario->update($data);
        return $usuario;
    }

    public function deleteUsuario($id)
    {
        $usuario = Usuario::findOrFail($id);
        return $usuario->delete();
    }
}