<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use  HasFactory, Notifiable;

    protected $table = 'usu_usuario';
    protected $primaryKey = 'usu_id';

    protected $fillable = [
        'usu_email',
        'usu_senha',
        'usu_is_adm',
        'usu_ativo',
        'usu_cpf',
        'usu_endereco',
        'usu_empresa',
        'usu_telefone',
        'usu_celular',
        'usu_tipo',
    ];

    protected $hidden = [
        'usu_senha',
    ];

    protected $casts = [
        'usu_is_adm' => 'boolean',
        'usu_ativo' => 'boolean',
        'usu_senha' => 'hashed',
    ];

    public function cursos()
    {
        return $this->belongsToMany(Curso::class, 'inscricoes', 'usu_id', 'cur_id');
    }
    
    public function inscricoes()
    {
        return $this->hasMany(Inscricao::class, 'usu_id', 'usu_id');
    }
}