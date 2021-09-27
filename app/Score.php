<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $connection = 'mysqlBionutrec';
    protected $table = 'score';
    public $timestamps = false;
    protected $fillable = [
        'id_jugador', 'score', 'fecha'
    ];

}
