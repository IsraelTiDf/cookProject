<?php

// app/Http/Controllers/ProdutoController.php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Interfaces\PedidoServiceInterface;
use App\Interfaces\PagamentoServiceInterface;
use Illuminate\Http\JsonResponse;
use Inertia\Inertia;

class PedidoController extends Controller
{
    protected $pedidoService;
    protected $pagamentoService;

    public function __construct(PedidoServiceInterface $pedidoService, PagamentoServiceInterface $pagamentoService)
    {
        $this->pedidoService = $pedidoService;
        $this->pagamentoService = $pagamentoService;
    }

    public function index()
    {
        $pedidos = $this->pedidoService->listarPedidos();
        
        // return view('Components.cliente.PedidosList', ['pedidos' => $pedidos]);
        return Inertia::render('Client/PedidosList',['pedidos' => $pedidos]);
    }
   

    public function show($id)
{
    $pedido = $this->pedidoService->encontrarPedidoPorId($id);

    if (!$pedido) {
        return response()->json(['mensagem' => 'Predido não encontrado'], 404);
    }

    return response()->json(['pedido' => $pedido]);
}

public function store(Request $request)
{
    $dados = $request->all();
    // Pagamento sendo Efetuado pela API so que nao disponibilizei as credenciais dela
    $pagamento = ($dados['formaPagamento'] <> 'DINHEIRO') ? $this->pagamentoService->realizarPagamento($dados) : null;
    // $pedido = ($pagamento === null || ($pagamento->getStatusCode() === 200)) ? $this->pedidoService->criarPedido($dados) : null;
    $pedido = $this->pedidoService->criarPedido($dados);
    return ($pedido === null) ? response()->json(['mensagem' => 'Pagamento não autorizado'], 401) : response()->json(['pedido' => $pedido], 201);
}

public function update(Request $request, $id)
{
    $dados = $request->all();

    $pedidoAtualizado = $this->pedidoService->atualizarPedido($dados, $id);

    if (!$pedidoAtualizado) {
        return response()->json(['mensagem' => 'Pedido não encontrado'], 404);
    }

    return response()->json(['mensagem' => 'Pedido atualizado com sucesso']);
}

public function destroy($id)
{
    $pedidoExcluido = $this->pedidoService->excluirPedido($id);

    if (!$pedidoExcluido) {
        return response()->json(['mensagem' => 'Pedido não encontrado'], 404);
    }

    return response()->json(['mensagem' => 'Pedido excluído com sucesso']);
}

public function estornarPedido(Request $id)
{
    $pedidoEstornado = $this->pagamentoService->realizarPagamento($id);

    // if (!$pedidoEstornado) {
    //     return response()->json(['mensagem' => 'Pedido não estornado'], 404);
    // }

    return response()->json(['mensagem' => 'Pedido estornado com sucesso']);
}


public function listarPedidos(): JsonResponse
{
    try {
        $pedidos = Pedido::all();
        // foreach ($pedidos as $pedido) {
        //     $pedido->produtos = json_decode($pedido->produtos);
        // }
        // dd($pedidos);
        return response()->json(['Pedidos' => $pedidos]);
    } catch (QueryException $e) {
        return response()->json(['mensagem' => 'Erro ao listar Pedidos: ' . $e->getMessage()], 500); 
    }
}


public function fetchPedidos(Request $request): JsonResponse
{
    $timeout = 10; // Tempo limite de espera em segundos
    $startTime = time();

    while (true) {
        $lastUpdatedTimestamp = $request->input('lastUpdated');
        $lastUpdatedDateTime = date('Y-m-d H:i:s', $lastUpdatedTimestamp);
        // dd($lastUpdatedDateTime);

        $pedidos = Pedido::where('created_at', '>', $lastUpdatedDateTime)->get();
        // dd($pedidos);

        if (!$pedidos->isEmpty()) {
            return response()->json(['Pedidos' => $pedidos]);
        }

        if (time() - $startTime >= $timeout) {
            return response()->json(['Pedidos' => [], 'timeout' => true]);
        }

        usleep(1000000);
    }
}




}
