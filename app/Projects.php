<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    /**
     * The database connection used by the model.
     *
     * @var string
     */
    protected $connection = 'mysqlEncuestas';
    
    protected $fillable = [
        'name', 'deleted_at', 'id_user', 
    ];
}
