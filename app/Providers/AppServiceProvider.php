<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\ProdutoServiceInterface;
use App\Services\ProdutoService;
use App\Interfaces\PedidoServiceInterface;
use App\Services\PedidoService;
use App\Interfaces\PagamentoServiceInterface;
use App\Services\PagamentoService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProdutoServiceInterface::class, ProdutoService::class);
        $this->app->bind(PedidoServiceInterface::class, PedidoService::class);
        $this->app->bind(PagamentoServiceInterface::class, PagamentoService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
