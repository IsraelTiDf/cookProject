<?php

// app/Interfaces/ProdutoServiceInterface.php

namespace App\Interfaces;

interface ProdutoServiceInterface
{
    public function listarProdutos();

    public function encontrarProdutoPorId($id);

    public function criarProduto(array $dados);

    public function atualizarProduto(array $dados, $id);

    public function excluirProduto($id);
}
