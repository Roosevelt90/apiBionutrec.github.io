<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSurvey extends Model
{
    /**
     * The database connection used by the model.
     *
     * @var string
     */
    protected $connection = 'mysqlEncuestas';
    
    protected $table = 'user_survey';

    protected $fillable = [
        'id_user', 'id_survey'
    ];
}
