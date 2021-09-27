<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoUsuario extends Model
{
    /**
     * The database connection used by the model.
     *
     * @var string
     */
    protected $connection = 'mysqlBionutrec';
    
    protected $table = 'tipo_usuario';
    
    protected $fillable = [
        'nombre'
    ];
}
