<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    /**
     * The database connection used by the model.
     *
     * @var string
     */
    protected $connection = 'mysqlEncuestas';
    
    protected $table = 'contact';

    protected $fillable = [
        'name', 'last_name', 'id_type_identification', 'number_identification'
    ];

    public function nameTypeIdentification(){
        $rol = TypeIdentification::find($this->id_type_identification);
        return $rol->name;
    }
}
