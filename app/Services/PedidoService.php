<?php

// app/Services/PedidoService.php

namespace App\Services;

use App\Interfaces\PedidoServiceInterface;
use App\Models\Pedido;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

class PedidoService implements PedidoServiceInterface
{
    // ... (outros métodos)

    public function listarPedidos(): JsonResponse
    {
        try {
            $pedidos = Pedido::all();
            foreach ($pedidos as $pedido) {
                $pedido->produtos = json_decode($pedido->produtos);
            }
            // dd($pedidos);
            return response()->json(['Pedidos' => $pedidos]);
        } catch (QueryException $e) {
            return response()->json(['mensagem' => 'Erro ao listar Pedidos: ' . $e->getMessage()], 500); 
        }
    }

    public function encontrarPedidoPorId($id): JsonResponse
    {
        try {
            $pedido = Pedido::find($id);
            if (!$pedido) {
                return response()->json(['mensagem' => 'Pedido não encontrado'], 404);
            }
            return response()->json(['Pedido' => $pedido]);
        } catch (QueryException $e) {
            return response()->json(['mensagem' => 'Erro ao encontrar Pedido: ' . $e->getMessage()], 500);
        }
    }

    public function criarPedido(array $dados): JsonResponse
    {
        try {
            // dd($dados);
            $dados['produtos'] = json_encode($dados['dados']);
            $dados['nome_usuario'] = json_encode($dados['nome']);
            $dados['status'] = 'Em processo';
            $pedido = Pedido::create($dados);
            return response()->json(['Pedido' => $pedido], 201); // 201 Created
        } catch (QueryException $e) {
            return response()->json(['mensagem' => 'Erro ao criar Pedido: ' . $e->getMessage()], 500);
        }
    }

    public function atualizarPedido(array $dados, $id): JsonResponse
    {
        try {
            $pedido = Pedido::find($id);
            if (!$pedido) {
                return response()->json(['mensagem' => 'Pedido não encontrado'], 404);
            }
            $pedido->update($dados);
            return response()->json(['Pedido' => $pedido]);
        } catch (QueryException $e) {
            return response()->json(['mensagem' => 'Erro ao atualizar Pedido: ' . $e->getMessage()], 500);
        }
    }

    public function excluirPedido($id): JsonResponse
    {
        try {
            $pedido = Pedido::find($id);
            if (!$pedido) {
                return response()->json(['mensagem' => 'Pedido não encontrado'], 404);
            }
            $pedido->delete();
            return response()->json(['mensagem' => 'Pedido excluído com sucesso']);
        } catch (QueryException $e) {
            return response()->json(['mensagem' => 'Erro ao excluir Pedido: ' . $e->getMessage()], 500);
        }
    }
}
