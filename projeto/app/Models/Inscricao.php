<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscricao extends Model
{
    use HasFactory;

    protected $table = 'inscricoes';

    protected $fillable = [
        'cur_id',
        'usu_id',
        'ins_status',
        'ins_data_inscricao',
        'valor_pago',
    ];

    protected $casts = [
        'ins_data_inscricao' => 'datetime',
        'valor_pago' => 'decimal:2',
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'cur_id', 'cur_id');
    }

    public function aluno()
    {
        return $this->belongsTo(Usuario::class, 'usu_id', 'usu_id');
    }
}