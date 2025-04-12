<?php

namespace App\Services;

use App\Models\Curso;

class CursoService
{
    public function getAllCursos()
    {
        return Curso::all();
    }

    public function getCursoById($id)
    {
        return Curso::findOrFail($id);
    }

    public function getActiveCursos()
    {
        return Curso::where('cur_ativo', true)
            //Garante que os cursos estão em período de inscrição
            ->where('cur_data_inscricoes_inicio', '<=', now())
            ->where('cur_data_incricoes_fim', '>=', now())
            ->get();
    }

    public function createCurso(array $data)
    {
        return Curso::create($data);
    }

    public function updateCurso($id, array $data)
    {
        $curso = Curso::findOrFail($id);
        $curso->update($data);
        return $curso;
    }

    public function deleteCurso($id)
    {
        $curso = Curso::findOrFail($id);
        return $curso->delete();
    }
}