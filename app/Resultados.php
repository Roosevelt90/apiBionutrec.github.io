<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resultados extends Model
{
    public $timestamps = false;

    protected $connection = 'mysqlAulaVirtual';
    
    protected $table = 'resultados';

    protected $fillable = [
        'nombres', 'apellidos', 'numero_doc', 'fecha', 'celular'
    ];
}
