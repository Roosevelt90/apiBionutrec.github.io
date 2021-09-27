<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FieldsProjectXBD extends Model
{
    /**
     * The database connection used by the model.
     *
     * @var string
     */
    protected $connection = 'mysqlEncuestas';
    
    protected $table = 'fields_project_x_bd';

    protected $fillable = [
        'id_base_de_datos', 'id_fields_project', 'answer', 'question'
    ];
}
