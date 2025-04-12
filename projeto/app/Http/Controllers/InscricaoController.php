<?php

namespace App\Http\Controllers;

use App\Services\InscricaoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InscricaoController extends Controller
{
    protected $inscricaoService;

    public function __construct(InscricaoService $inscricaoService)
    {
        $this->inscricaoService = $inscricaoService;
    }

    public function index()
    {
        $inscricoes = $this->inscricaoService->getAllInscricoes();
        return response()->json($inscricoes);
    }

    public function show($id)
    {
        $inscricao = $this->inscricaoService->getInscricaoById($id);
        return response()->json($inscricao);
    }
    
    public function byCurso($curId)
    {
        $inscricoes = $this->inscricaoService->getInscricoesByCursoId($curId);
        return response()->json($inscricoes);
    }
    
    public function byAluno($aluId)
    {
        $inscricoes = $this->inscricaoService->getInscricoesByAlunoId($aluId);
        return response()->json($inscricoes);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cur_id' => 'required|exists:cur_curso,cur_id',
            'usu_id' => 'required|exists:usu_usuario,usu_id',
            'ins_status' => 'nullable|string',
            'valor_pago' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $inscricao = $this->inscricaoService->createInscricao($request->all());
            return response()->json($inscricao, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'ins_status' => 'nullable|string',
            'valor_pago' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $inscricao = $this->inscricaoService->updateInscricao($id, $request->all());
        return response()->json($inscricao);
    }
    
    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $inscricao = $this->inscricaoService->updateStatus($id, $request->input('status'));
        return response()->json($inscricao);
    }

    public function destroy($id)
    {
        $this->inscricaoService->deleteInscricao($id);
        return response()->json(null, 204);
    }
}