<?php

namespace App\Http\Controllers;

use App\Lunchbreak;
use App\Timecard;
use App\UserInfo;
use Illuminate\Http\Request;
use Auth;
class LunchbreakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        //
        return Lunchbreak::where('userinfo_id',Auth::user()->id)->latest()->limit(1)->get();
    }
    public function getAlllunchbreak(Request $request){
        $from = date($request['date_from']);
        $to = date($request['date_to']);
        return Lunchbreak::with('userinfo.user')->whereBetween('created_at',[$from.' 00:00:00',$to.' 23:59:59'])->latest()->get();  
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
         $user = UserInfo::where('user_id',Auth::user()->id)->latest()->limit(1)->get();
       $schedule = $user->first()->schedule_id;
       //Store First Break in Database
        Lunchbreak::create([
            'started_at' => NOW(),
            'userinfo_id' => Auth::user()->id,
            'schedule_id' => $schedule,
            'timecard_id' => $request['timecard_id']
        ]);
        //Update to is Working Status

        $timecard = Timecard::findOrFail($request['timecard_id']);
        $timecard->update([
            'is_working' => FALSE,
        ]);
        return 'Success';
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Lunchbreak  $lunchbreak
     * @return \Illuminate\Http\Response
     */
    public function show(Lunchbreak $lunchbreak)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lunchbreak  $lunchbreak
     * @return \Illuminate\Http\Response
     */
    public function edit(Lunchbreak $lunchbreak)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lunchbreak  $lunchbreak
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lunchbreak $lunchbreak)
    {
        //\
         $break = Lunchbreak::findOrFail($lunchbreak->id);
        $break->update([
            'stopped_at' => NOW()
        ]);

        $timecard = Timecard::findOrFail($break->timecard_id);
        $timecard->update([
            'is_working' => TRUE,
            'done_lunch' => TRUE
        ]);
        $schedule = $break->with('schedule')->latest()->limit(1)->get();
        return /*$schedule->schedule[0]->time_out*/$schedule[0]->schedule->time_out;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lunchbreak  $lunchbreak
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lunchbreak $lunchbreak)
    {
        //
    }
}
