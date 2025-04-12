<?php

namespace App\Http\Controllers;

use App\Services\CursoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CursoController extends Controller
{
    protected $cursoService;

    public function __construct(CursoService $cursoService)
    {
        $this->cursoService = $cursoService;
    }

    public function index()
    {
        $cursos = $this->cursoService->getAllCursos();
        return response()->json($cursos);
    }

    public function active()
    {
        $cursos = $this->cursoService->getActiveCursos();
        return response()->json($cursos);
    }

    public function show($id)
    {
        $curso = $this->cursoService->getCursoById($id);
        return response()->json($curso);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cur_nome' => 'required|string|max:255',
            'cur_descricao' => 'required|string',
            'cur_valor' => 'required|numeric',
            'cur_data_inscricoes_inicio' => 'required|date',
            'cur_data_inscricoes_fim' => 'required|date|after:cur_data_inscricoes_inicio',
            'cur_vagas' => 'required|integer|min:1',
            'cur_ativo' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $curso = $this->cursoService->createCurso($request->all());
        return response()->json($curso, 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'cur_nome' => 'string|max:255',
            'cur_descricao' => 'string',
            'cur_valor' => 'numeric',
            'cur_data_inscricoes_inicio' => 'date',
            'cur_data_inscricoes_fim' => 'date|after:cur_data_inscricoes_inicio',
            'cur_vagas' => 'integer|min:1',
            'cur_ativo' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $curso = $this->cursoService->updateCurso($id, $request->all());
        return response()->json($curso);
    }

    public function destroy($id)
    {
        $this->cursoService->deleteCurso($id);
        return response()->json(null, 204);
    }
}