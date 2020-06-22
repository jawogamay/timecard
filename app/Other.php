<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Other extends Model
{
    //
    protected $fillable = [
        'userinfo_id','name','started_at','stopped_at','timecard_id','time_outexpire'
    ];

    public function userinfo(){
        return $this->belongsTo('App\UserInfo');
    }
}
