<?php

// app/Interfaces/ProdutoServiceInterface.php

namespace App\Interfaces;

interface PedidoServiceInterface
{
    public function listarPedidos();

    public function encontrarPedidoPorId($id);

    public function criarPedido(array $dados);

    public function atualizarPedido(array $dados, $id);

    public function excluirPedido($id);
}
