<?php

namespace App\Services;

use App\Models\Inscricao;
use App\Models\Curso;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;

class InscricaoService
{
    public function getAllInscricoes()
    {
        return Inscricao::with(['curso', 'aluno'])->get();
    }

    public function getInscricaoById($id)
    {
        return Inscricao::with(['curso', 'aluno'])->findOrFail($id);
    }

    public function getInscricoesByCursoId($curId)
    {
        return Inscricao::with('aluno')
            ->where('cur_id', $curId)
            ->get();
    }

    public function getInscricoesByAlunoId($usuId)
    {
        return Inscricao::with('curso')
            ->where('usu_id', $usuId)
            ->get();
    }

    public function createInscricao(array $data)
    {
        // Verificar se o curso existe e tem vagas disponíveis
        $curso = Curso::findOrFail($data['cur_id']);
        
        // Verificar se o aluno já está inscrito neste curso
        $existingInscricao = Inscricao::where('cur_id', $data['cur_id'])
            ->where('usu_id', $data['usu_id'])
            ->first();
            
        if ($existingInscricao) {
            throw new \Exception('Aluno já inscrito neste curso.');
        }
        
        // Verificar se há vagas disponíveis
        $inscricoesCount = Inscricao::where('cur_id', $data['cur_id'])->count();
        if ($inscricoesCount >= $curso->cur_vagas) {
            throw new \Exception('Não há vagas disponíveis para este curso.');
        }
        
        // Verificar se o curso está no período de inscrição
        $now = now();
        if ($now < $curso->cur_data_inscricoes_inicio || $now > $curso->cur_data_inscricoes_fim) {
            throw new \Exception('Este curso não está no período de inscrições.');
        }
        
        // Se não definido, usar o valor do curso
        if (!isset($data['valor_pago'])) {
            $data['valor_pago'] = $curso->cur_valor;
        }
        
        // Criar a inscrição
        $inscricao = Inscricao::create($data);
        
        return $inscricao;
    }

    public function updateInscricao($id, array $data)
    {
        $inscricao = Inscricao::findOrFail($id);
        $inscricao->update($data);
        return $inscricao;
    }

    public function deleteInscricao($id)
    {
        $inscricao = Inscricao::findOrFail($id);
        return $inscricao->delete();
    }
    
    public function updateStatus($id, $status)
    {
        $inscricao = Inscricao::findOrFail($id);
        $inscricao->ins_status = $status;
        $inscricao->save();
        return $inscricao;
    }
}