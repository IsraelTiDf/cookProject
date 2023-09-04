<?php

// app/Interfaces/ProdutoServiceInterface.php

namespace App\Interfaces;

interface PagamentoServiceInterface
{
    public function realizarPagamento($data);

    public function cancelarPagamento($id);

    // public function capturarPagamento(array $dados);

}
