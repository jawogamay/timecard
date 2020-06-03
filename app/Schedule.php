<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    //
    protected $fillable = [
        'nameshift','time_in','time_out','fbreak_in','fbreak_out','lunch_in','lunch_out','last_in','last_out'
    ];

    public function firstbreak(){
        return $this->hasOne('App\Firstbreak');
    }
    public function userinfo(){
        return $this->belongsTo('App\UserInfo');
    }
}
