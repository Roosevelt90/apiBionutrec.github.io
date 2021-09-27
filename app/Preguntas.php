<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Preguntas extends Model
{
    /**
     * The database connection used by the model.
     *
     * @var string
     */
    protected $connection = 'mysqlBionutrec';
    
    protected $table = 'preguntas';

    protected $fillable = [
        'id_tema', 'nombre'
    ];

}
