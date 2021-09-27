<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Respuestas extends Model
{
    /**
     * The database connection used by the model.
     *
     * @var string
     */
    protected $connection = 'mysqlBionutrec';
    
    protected $table = 'respuestas';

    protected $fillable = [
        'id_preguntas', 'nombre'
    ];
}
