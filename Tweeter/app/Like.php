<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = 'likes';

    function user(){
        return $this->belongsTo('App\User');
    }
    function tweet(){
        return $this->belongsTo('App\Tweet');
    }
}
