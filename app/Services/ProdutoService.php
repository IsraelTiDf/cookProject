<?php

// app/Services/ProdutoService.php

namespace App\Services;

use App\Interfaces\ProdutoServiceInterface;
use App\Models\Produto;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

class ProdutoService implements ProdutoServiceInterface
{
    // ... (outros métodos)

    public function listarProdutos(): JsonResponse
    {
        try {
            $produtos = Produto::all();
            return response()->json(['produtos' => $produtos]);
        } catch (QueryException $e) {
            return response()->json(['mensagem' => 'Erro ao listar produtos: ' . $e->getMessage()], 500); 
        }
    }

    public function encontrarProdutoPorId($id): JsonResponse
    {
        try {
            $produto = Produto::find($id);
            if (!$produto) {
                return response()->json(['mensagem' => 'Produto não encontrado'], 404);
            }
            return response()->json(['produto' => $produto]);
        } catch (QueryException $e) {
            return response()->json(['mensagem' => 'Erro ao encontrar produto: ' . $e->getMessage()], 500);
        }
    }

    public function criarProduto(array $dados): JsonResponse
    {
        try {
            $produto = Produto::create($dados);
            return response()->json(['produto' => $produto], 201); // 201 Created
        } catch (QueryException $e) {
            return response()->json(['mensagem' => 'Erro ao criar produto: ' . $e->getMessage()], 500);
        }
    }

    public function atualizarProduto(array $dados, $id): JsonResponse
    {
        try {
            $produto = Produto::find($id);
            if (!$produto) {
                return response()->json(['mensagem' => 'Produto não encontrado'], 404);
            }
            $produto->update($dados);
            return response()->json(['produto' => $produto]);
        } catch (QueryException $e) {
            return response()->json(['mensagem' => 'Erro ao atualizar produto: ' . $e->getMessage()], 500);
        }
    }

    public function excluirProduto($id): JsonResponse
    {
        try {
            $produto = Produto::find($id);
            if (!$produto) {
                return response()->json(['mensagem' => 'Produto não encontrado'], 404);
            }
            $produto->delete();
            return response()->json(['mensagem' => 'Produto excluído com sucesso']);
        } catch (QueryException $e) {
            return response()->json(['mensagem' => 'Erro ao excluir produto: ' . $e->getMessage()], 500);
        }
    }
}
