<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'private_messages';

    function user(){
        return $this->hasMany('App\User');
        }
}
