<?php

// app/Repositories/CieloRepository.php

namespace App\Repositories;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class CieloRepository
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://apisandbox.cieloecommerce.cielo.com.br',
            'headers' => [
                'Content-Type' => 'application/json',
                'MerchantId' => env('MERCHANT_ID'),
                'MerchantKey' => env('MERCHANT_KEY'),
            ],
        ]);
    }

    public function realizarPagamento(array $dadosPagamento)
    {
        try {
            $response = $this->client->post('/1/sales', [
                'json' => $dadosPagamento,
            ]);
            
            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function atualizarPagamento($url)
    {
            $response = Http::put($url, [
                'Content-Type' => 'application/json',
                'MerchantId' => env('MERCHANT_ID'),
                'MerchantKey' => env('MERCHANT_KEY'),
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data;
            } else {
                $errorData = $response->json();
                return $errorData;
            }
    }
}
