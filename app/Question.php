<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /**
     * The database connection used by the model.
     *
     * @var string
     */
    protected $connection = 'mysqlEncuestas';
    
    protected $table = 'question';
    
    protected $fillable = [
        'name', 'name_id', 'id_survey', 'id_type', 'required', 'header', 'values', 'deleted_at'
    ];
}
