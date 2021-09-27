<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FieldsProject extends Model
{
    /**
     * The database connection used by the model.
     *
     * @var string
     */
    protected $connection = 'mysqlEncuestas';
    
    protected $table = 'fields_project';
    
    protected $fillable = [
        'name', 'name_id', 'id_project', 'id_type', 'values', 'deleted_at', 'validacion'
    ];
}
