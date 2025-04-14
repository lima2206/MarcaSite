<?php

namespace App\Http\Controllers;

use App\Models\Curso;
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
            'cur_imagem' => 'nullable|image', 
            'cur_material' => 'nullable|file'  
        ]);
    
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        // Find the course
        $curso = Curso::findOrFail($id);
        $data = $request->only(['cur_nome', 'cur_descricao', 'cur_valor', 'cur_data_inscricoes_inicio', 'cur_data_inscricoes_fim', 'cur_ativo', 'cur_vagas']);
    
        // Handle cur_imagem update if a new file is uploaded
        if ($request->hasFile('cur_imagem')) {
            // Delete old image file if it exists
            if ($curso->cur_imagem) {
                Storage::disk('public')->delete($curso->cur_imagem);  // Delete old file
            }
    
            // Upload new image
            $imagem = $request->file('cur_imagem');
            $nomeImagem = Str::random(40) . '.' . $imagem->getClientOriginalExtension();
            $caminhoImagem = $imagem->storeAs('imagens', $nomeImagem, 'public');  // Store the image
            $data['cur_imagem'] = $caminhoImagem;  // Update the path in the data array
        }
    
        // Handle cur_material update if a new file is uploaded
        if ($request->hasFile('cur_material')) {
            // Delete old material file if it exists
            if ($curso->cur_material) {
                Storage::disk('public')->delete($curso->cur_material);  // Delete old file
            }
    
            // Upload new material
            $material = $request->file('cur_material');
            $nomeMaterial = Str::random(40) . '.' . $material->getClientOriginalExtension();
            $caminhoMaterial = $material->storeAs('materiais', $nomeMaterial, 'public');  // Store the material
            $data['cur_material'] = $caminhoMaterial;  // Update the path in the data array
        }
    
        // Update the course with the new data, including the image/material paths
        $curso->update($data);
    
        // Return the updated course data
        return response()->json($curso, 200);
    }
    

    public function destroy($id)
    {
        $this->cursoService->deleteCurso($id);
        return response()->json(null, 204);
    }
}