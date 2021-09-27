<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estrategia extends Model
{
    public $timestamps = false;

    protected $connection = 'mysqlAulaVirtual';
    
    protected $table = 'estrategia';

    protected $fillable = [
        'texto'
    ];

    public function preguntas()
    {
        return $this->belongsTo('App\RespuestasAula', 'id');
    }
}
