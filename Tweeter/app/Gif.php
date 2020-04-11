<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gif extends Model
{
    protected $table = '_g_i_f';

    function user(){
     return $this->belongsTo('App\User');
     }

     function tweet(){
         return $this->belongsTo('App\Tweet');
     }
}
