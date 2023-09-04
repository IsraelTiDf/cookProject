<?php

// app/Http/Controllers/ProdutoController.php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\ProdutoServiceInterface;

class ProdutoController extends Controller
{
    protected $produtoService;

    public function __construct(ProdutoServiceInterface $produtoService)
    {
        $this->produtoService = $produtoService;
    }

    public function index()
    {
        $produtos = $this->produtoService->listarProdutos();
        return view('produtos.index', ['produtos' => $produtos]);
    }

    public function show($id)
{
    $produto = $this->produtoService->encontrarProdutoPorId($id);

    if (!$produto) {
        return response()->json(['mensagem' => 'Produto não encontrado'], 404);
    }

    return response()->json(['produto' => $produto]);
}

public function store(Request $request)
{
    $dados = $request->all();

    // Validação dos dados, se necessário
    // ...

    $produto = $this->produtoService->criarProduto($dados);

    return response()->json(['produto' => $produto], 201);
}

public function update(Request $request, $id)
{
    $dados = $request->all();

    $produtoAtualizado = $this->produtoService->atualizarProduto($dados, $id);

    if (!$produtoAtualizado) {
        return response()->json(['mensagem' => 'Produto não encontrado'], 404);
    }

    return response()->json(['mensagem' => 'Produto atualizado com sucesso']);
}

public function destroy($id)
{
    $produtoExcluido = $this->produtoService->excluirProduto($id);

    if (!$produtoExcluido) {
        return response()->json(['mensagem' => 'Produto não encontrado'], 404);
    }

    return response()->json(['mensagem' => 'Produto excluído com sucesso']);
}


}
