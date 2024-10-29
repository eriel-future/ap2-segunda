<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Responses\ApiResponse;  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProdutoController extends Controller
{
    public function listarTodos()
    {
        $customers = Produto::all();
        return response()->json([
            'status' => true,
            'message' => 'produtos criado com sucesso',
            'data' => $customers
        ], 200);
    }

    public function listarPeloId(int $id)
    {
        $customer = Produto::findOrFail($id);
        return response()->json([
            'status' => true,
            'message' => 'produto listado com sucesso',
            'data' => $customer
        ], 200);
    }

    public function criar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:200',
            'cpf' => 'required|string|max:15',
            'ano de nascimento'=> 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $customer = Produto::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Produto criado com sucesso',
            'data' => $customer
        ], 201);
    }

    public function editar(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:15' . $id,
            'ano de nascimento' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $customer = Produto::findOrFail(  $id);
        $customer->editar($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Produto atualizado com sucesso',
            'data' => $customer
        ], 200);
    }

    public function deletar($id)
    {
        $customer = Produto::findOrFail($id);
        $customer->delete();
        
        return response()->json([
            'status' => true,
            'message' => 'Produto deletado com sucesso'
        ], 204);
    }
}