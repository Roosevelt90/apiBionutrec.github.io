<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RespuestasAula extends Model
{
    public $timestamps = false;

    protected $connection = 'mysqlAulaVirtual';
    
    protected $table = 'respuestas';

    protected $fillable = [
        'titulo'
    ];

    public function preguntas()
    {
        return $this->belongsTo('App\Pregunta', 'id');
    }

    public function estrategia()
    {
        return $this->hasOne('App\Estrategia', 'estrategia_id');
    }
}
