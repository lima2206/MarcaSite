<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    protected $table = 'cur_curso';
    protected $primaryKey = 'cur_id';

    protected $fillable = [
        'cur_nome',
        'cur_descricao',
        'cur_valor',
        'cur_data_inscricoes_inicio',
        'cur_data_inscricoes_fim',
        'cur_vagas',
        'cur_ativo',
        'cur_imagem',
        'cur_material'
    ];

    protected $casts = [
        'cur_valor' => 'decimal:2',
        'cur_data_inscricoes_inicio' => 'datetime',
        'cur_data_inscricoes_fim' => 'datetime',
        'cur_vagas' => 'integer',
        'cur_ativo' => 'boolean',
    ];

    public function alunos()
    {
        return $this->belongsToMany(Usuario::class, 'inscricoes', 'cur_id', 'usu_id');
    }
    
    public function inscricoes()
    {
        return $this->hasMany(Inscricao::class, 'cur_id', 'cur_id');
    }
}