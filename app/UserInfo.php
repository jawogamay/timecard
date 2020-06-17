<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    //
    protected $fillable = [
        'user_id','schedule_id','department','position','details','name'
    ];

    public function schedule(){
        return $this->belongsTo('App\Schedule');
    }
    public function timecard(){
        return $this->hasMany('App\Timecard');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
}
