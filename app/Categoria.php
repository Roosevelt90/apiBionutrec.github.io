<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    public $timestamps = false;

    protected $connection = 'mysqlAulaVirtual';
    
    protected $table = 'categoria';

    protected $fillable = [
        'nombre'
    ];

    public function preguntas()
    {
        return $this->hasMany(Pregunta::class);
    }
}
