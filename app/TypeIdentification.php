<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeIdentification extends Model
{
    /**
     * The database connection used by the model.
     *
     * @var string
     */
    protected $connection = 'mysqlEncuestas';
    
    protected $table = 'type_identification';
}
