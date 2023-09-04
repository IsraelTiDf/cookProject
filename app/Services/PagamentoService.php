<?php

// app/Services/PedidoService.php

namespace App\Services;

use App\Interfaces\PagamentoServiceInterface;
use App\Models\Pagamento;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use App\Services\PaymentDataBuilder;
use App\Repositories\CieloRepository;

class PagamentoService implements PagamentoServiceInterface
{

    protected $cieloRepository;

    public function __construct(CieloRepository $cieloRepository)
    {
        $this->cieloRepository = $cieloRepository;
    }


    public function realizarPagamento($data): JsonResponse
    {
        try {

            $customerData = [
                'Name' => $data['nome'], // Usar o nome do $data
                // 'Email' => $data['email'], // Você pode adicionar 'Email' se necessário
            ];
    
            $creditCardData = [
                'CardNumber' => str_replace(' ', '', $data['numeroCartao']), // Remover espaços no número do cartão
                'Holder' => $data['nome'], // Usar o nome do $data como o titular do cartão
                // 'ExpirationDate' => $data['dataExpiracao'], // Usar a data de expiração do $data
                'ExpirationDate' => '08/2025',
                'SecurityCode' => $data['codigoSeguranca'], // Usar o código de segurança do $data
                'SaveCard' => 'false',
                'Brand' => 'Visa', // Você pode determinar a bandeira com base no número do cartão, se necessário
                'CardOnFile' => [
                    'Usage' => 'Used',
                    'Reason' => 'Unscheduled',
                ],
            ];
    

            $amount = $data['preco'];

            $dadosPagamento = PaymentDataBuilder::build($customerData, $creditCardData, $amount);
            
            $dadosApi = $this->cieloRepository->realizarPagamento($dadosPagamento);

            // Verifique se a resposta da API contém "ReturnMessage" igual a "Operation Successful"
            if ($dadosApi['Payment']['ReturnMessage'] === 'Operation Successful') {
                $pagamento = new Pagamento([
                    'pedido_id' => $dadosApi['MerchantOrderId'],
                    'valor' => $dadosApi['Payment']['Amount'] / 100,
                    'tipo_pagamento' => $dadosApi['Payment']['Type'],
                    'status_pagamento' => $dadosApi['Payment']['Status'],
                    'link_consulta' => $dadosApi['Payment']['Links'][0]['Href'],
                    'link_estorno' => $dadosApi['Payment']['Links'][1]['Href'],
                ]);

                // Salve o pagamento no banco de dados
                $pagamento->save();

                return response()->json(['message' => 'Pagamento realizado com sucesso'], 200);
            } else {
                return response()->json(['error' => 'A operação não foi bem-sucedida'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



    public function cancelarPagamento($id): JsonResponse
    {
        try {
            $pagamento = Pagamento::find($id);
            $dadosApi = $this->cieloRepository->realizarPagamento($pagamento);

            if($dadosApi)
            {
                return response()->json(['message' => 'Pagamento realizado com sucesso'], 200);
            } else {
                return response()->json(['error' => 'A operação não foi bem-sucedida'], 400);
            }

        } catch (QueryException $e) {
            return response()->json(['mensagem' => 'Erro ao encontrar Pedido: ' . $e->getMessage()], 500);
        }
    }

    // public function capturarPagamento($id): JsonResponse
    // {
    //     try {

    //         return response()->json(['mensagem' => 'Pedido excluído com sucesso']);
    //     } catch (QueryException $e) {
    //         return response()->json(['mensagem' => 'Erro ao excluir Pedido: ' . $e->getMessage()], 500);
    //     }
    // }
}
