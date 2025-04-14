<?php

namespace App\Http\Controllers;

use App\Services\CursoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Storage;
use Str;

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
            'cur_imagem' => 'nullable|image',
            'cur_material' => 'nullable|file'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        if ($request->hasFile('cur_imagem')) {
            $imagem = $request->file('cur_imagem');
            $nomeImagem = Str::random(40) . '.' . $imagem->getClientOriginalExtension();
            $caminhoImagem = $imagem->storeAs('imagens', $nomeImagem, 'public');
            $data['cur_imagem'] = $caminhoImagem;
        }
    
        if ($request->hasFile('cur_material')) {
            $material = $request->file('cur_material');
            $nomeMaterial = Str::random(40) . '.' . $material->getClientOriginalExtension();
            $caminhoMaterial = $material->storeAs('materiais', $nomeMaterial, 'public');
            $data['cur_material'] = $caminhoMaterial;
        }
    
        $curso = $this->cursoService->createCurso($data);
    
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
            'cur_imagem' => 'image',
            'cur_material' => 'file'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        $data = $request->all();
    
        if ($request->hasFile('cur_imagem')) {
            $data['cur_imagem'] = Storage::disk('public')->putFile('/', $request->file('cur_imagem'));
        }
    
        if ($request->hasFile('cur_material')) {
            $data['cur_material'] = Storage::disk('local')->putFile('/', $request->file('cur_material'));
        }
    
        $curso = $this->cursoService->updateCurso($id, $data);
        return response()->json($curso);
    }

    public function destroy($id)
    {
        $this->cursoService->deleteCurso($id);
        return response()->json(null, 204);
    }
}