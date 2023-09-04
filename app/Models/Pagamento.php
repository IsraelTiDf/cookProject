<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class  Pagamento extends Model
{
    // use HasFactory;
    // use SoftDeletes;
     use HasFactory;
     /**
      * The attributes that are mass assignable.
      *
      * @var array
      */
     protected $fillable = [
        'pedido_id',
        'valor',
        'tipo_pagamento',
        'status_pagamento',
        'link_estorno',
        'link_consulta',
        'created_at',
        'updated_at',
     ];
     
     protected $table = 'pagamentos'; // Especifica o nome da tabela
     protected $primaryKey = 'id'; // Define a chave primária
 
   //   public $timestamps = false; 
     public $incrementing = true;


}     




