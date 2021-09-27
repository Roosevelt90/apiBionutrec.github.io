<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jugador extends Model
{
    /**
     * The database connection used by the model.
     *
     * @var string
     */
    protected $connection = 'mysqlBionutrec';
    public $timestamps = false;
    protected $table = 'jugador';

    protected $fillable = [
        'id_tipo_usuario', 'nombre', 'apellido', 'numero_identificacion', 'rol'
    ];

}
