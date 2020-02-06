<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    protected $table = 'tweets';

    function user(){
        return $this->belongsTo('App\User');
    }
    function like(){
        return $this->hasMany('App\Like');
    }
    function comment(){
        return $this->hasMany('App\Comment');
    }
}
