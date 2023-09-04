<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class  Pedido extends Model
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
        'produtos',
        'nome_usuario',
        'status',
        'created_at',
        'updated_at',
     ];
     
     protected $table = 'pedidos'; // Especifica o nome da tabela
     protected $primaryKey = 'id'; // Define a chave primária
 
    //  public $timestamps = false; 
     public $incrementing = true;
     
     
    //  protected $dates = ['DHS_CADASTRO', 'DHS_ATUALIZACAO', 'DHS_EXCLUSAO_LOGICA'];
     
    //  const CREATED_AT = 'DHS_CADASTRO';
    //  const UPDATED_AT = 'DHS_ATUALIZACAO';
    //  const DELETED_AT = 'DHS_EXCLUSAO_LOGICA';
     
     // Relations

}     




