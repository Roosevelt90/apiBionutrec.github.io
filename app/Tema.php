<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tema extends Model
{
    /**
     * The database connection used by the model.
     *
     * @var string
     */
    protected $connection = 'mysqlBionutrec';
    
    protected $table = 'tema';
    
    protected $fillable = ['nombre'];
}
