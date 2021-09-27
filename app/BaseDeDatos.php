<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaseDeDatos extends Model
{
    /**
     * The database connection used by the model.
     *
     * @var string
     */
    protected $connection = 'mysqlEncuestas';
    
    protected $table = 'base_de_datos';

    protected $fillable = [
        'name', 'last_name', 'id_type_identification', 'id_project', 'number_identification'
    ];

}
