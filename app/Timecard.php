<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timecard extends Model
{
    //
    protected $fillable = [
            'userinfo_id','time_in','time_out','work_flag','late_flag','is_working','done_fbreak','done_lunch','done_lbreak','hours','minutes','time_outexpire','reason'
    ];

    public function userinfo(){
        return $this->belongsTo('App\UserInfo');
    }
}
