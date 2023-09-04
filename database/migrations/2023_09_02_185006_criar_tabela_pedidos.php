<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CriarTabelaPedidos extends Migration
{
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            // $table->string('produtos'); 
            $table->text('produtos');
            $table->string('nome_usuario');
            $table->string('status');
            $table->timestamps();
            
        });
    }

    public function down()
    {
        Schema::dropIfExists('pedidos');
    }

}
