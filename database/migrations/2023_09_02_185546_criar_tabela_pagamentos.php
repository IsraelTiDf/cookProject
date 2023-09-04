<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CriarTabelaPagamentos extends Migration
{
    public function up()
    {
        Schema::create('pagamentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pedido_id'); 
            $table->decimal('valor', 10, 2);
            $table->string('tipo_pagamento');
            $table->string('status_pagamento');
            $table->string('link_estorno');
            $table->string('link_consulta');
            $table->timestamps();
            
            // $table->foreign('pedido_id')->references('id')->on('pedidos');
        });
    }

    

    public function down()
    {
        Schema::dropIfExists('pagamentos');
    }
}

