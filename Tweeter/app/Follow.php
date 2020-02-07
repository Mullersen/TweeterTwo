<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $table = 'follow';
    //Laravel does not need a primary key. Therefore I have not defined a promary key for this table.
    public $timestamps = false;
    protected $primaryKey = 'followed_user';
    public $incrementing = false;
    public $keyType = 'string';

    function user(){
        return $this->belongsTo('App\User');
    }
}
