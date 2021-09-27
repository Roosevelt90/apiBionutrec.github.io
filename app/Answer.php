<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    /**
     * The database connection used by the model.
     *
     * @var string
     */
    protected $connection = 'mysqlEncuestas';
    
    protected $table = 'answer';
    
    protected $fillable = ['id_result', 'id_question', 'answer', 'question', 'justificacion'];
}
