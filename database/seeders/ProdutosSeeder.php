<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdutosSeeder extends Seeder
{
    public function run()
    {
        DB::table('produtos')->insert([
            'nome' => 'Sushi Especial',
            'descricao' => 'Uma deliciosa seleção de sushis frescos.',
            'preco' => 24.99,
            'image' => 'img/sushi-especial.jpg',
        ]);

        DB::table('produtos')->insert([
            'nome' => 'Tempurá de Camarão',
            'descricao' => 'Camarões empanados e crocantes com molho especial.',
            'preco' => 19.99,
            'image' => 'img/Tempura.jpg',
        ]);

        DB::table('produtos')->insert([
            'nome' => 'Sashimi Misto',
            'descricao' => 'Uma seleção fresca de sashimis variados.',
            'preco' => 29.99,
            'image' => 'img/Sashimi.jpg',
        ]);
        
        DB::table('produtos')->insert([
            'nome' => 'Yakitori de Frango',
            'descricao' => 'Espetos de frango grelhado com molho teriyaki.',
            'preco' => 15.99,
            'image' => 'img/Yakitori.jpg',
        ]);
        
        DB::table('produtos')->insert([
            'nome' => 'Rolinho Primavera',
            'descricao' => 'Rolinhos primavera recheados com legumes e carne.',
            'preco' => 9.99,
            'image' => 'img/Rolinho.jpg',
        ]);
        
        DB::table('produtos')->insert([
            'nome' => 'Tartar de Salmão',
            'descricao' => 'Tartar de salmão fresco com abacate e cebolinha.',
            'preco' => 22.99,
            'image' => 'img/Tartar.jpg',
        ]);
        
        DB::table('produtos')->insert([
            'nome' => 'Missoshiro',
            'descricao' => 'Sopa de missô quente com tofu e cebolinha.',
            'preco' => 7.99,
            'image' => 'img/Missoshiro.jpg',
        ]);
        
        DB::table('produtos')->insert([
            'nome' => 'Sunomono',
            'descricao' => 'Salada de pepino agridoce com gergelim.',
            'preco' => 8.99,
            'image' => 'img/Sunomono.jpg',
        ]);

    }
}
