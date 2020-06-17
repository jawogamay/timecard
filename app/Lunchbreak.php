<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lunchbreak extends Model
{
    //
    protected $fillable = [
        'userinfo_id','schedule_id','started_at','stopped_at','timecard_id','overbreak','time_outexpire'
    ];

    public function userinfo(){
        return $this->belongsTo('App\Userinfo');
    }
    public function schedule(){
        return $this->belongsTo('App\Schedule');
    }
}
