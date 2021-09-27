<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    /**
     * The database connection used by the model.
     *
     * @var string
     */
    protected $connection = 'mysqlEncuestas';
    
    protected $table = 'survey';
    
    protected $fillable = [
        'name', 'deleted_at', 'id_user', 'id_project', 'date_begin', 'date_end'
    ];

    public function idHash(){
        $result = '';
        for($i=0; $i<strlen($this->id); $i++) {
           $char = substr($this->id, $i, 1);
           $keychar = substr($_ENV['KEY_PASS_SURVEY'], ($i % strlen($_ENV['KEY_PASS_SURVEY']))-1, 1);
           $char = chr(ord($char)+ord($keychar));
           $result.=$char;
        }
        return base64_encode($result);
        //return openssl_encrypt ($this->id, 'aes-256-cbc', $_ENV['KEY_PASS_SURVEY'], false, base64_decode("C9fBxl1EWtYTL1/M8jfstw=="));
    }

    public function date_begin_format(){
        return  date("Y-m-d", strtotime($this->date_begin)); 
    }

    public function date_end_format(){
        return  date("Y-m-d", strtotime($this->date_end)); 
    }

}
