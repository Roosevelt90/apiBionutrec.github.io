<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    public $timestamps = false;

    protected $connection = 'mysqlAulaVirtual';
    
    protected $table = 'pregunta';

    protected $fillable = [
        'titulo'
    ];

    public function categorias()
    {
        return $this->belongsTo('App\Categoria', 'id');
    }

    public function respuestas()
    {
        return $this->hasMany('App\RespuestasAula', 'pregunta_id');
    }

}
