<?php

namespace App\Http\Controllers;

use App\Lastbreak;
use App\Timecard;
use App\UserInfo;
use Auth;
use Illuminate\Http\Request;
class LastbreakController extends Controller
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
         return Lastbreak::where('userinfo_id',Auth::user()->id)->latest()->limit(1)->get();
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
        Lastbreak::create([
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
     * @param  \App\Lastbreak  $lastbreak
     * @return \Illuminate\Http\Response
     */
    public function show(Lastbreak $lastbreak)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lastbreak  $lastbreak
     * @return \Illuminate\Http\Response
     */
    public function edit(Lastbreak $lastbreak)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lastbreak  $lastbreak
     * @return \Illuminate\Http\Response
     */
    public function getAllLastbreak(Request $request){
         $from = date($request['date_from']);
        $to = date($request['date_to']);
        return Lastbreak::with('userinfo.user')->whereBetween('created_at',[$from.' 00:00:00',$to.' 23:59:59'])->latest()->get(); 
    }
    public function update(Request $request, Lastbreak $lastbreak)
    {
        //
         $break = Lastbreak::findOrFail($lastbreak->id);
        $break->update([
            'stopped_at' => NOW()
        ]);

        $timecard = Timecard::findOrFail($break->timecard_id);
        $timecard->update([
            'is_working' => TRUE,
            'done_lbreak' => TRUE
        ]);
        $schedule = $break->with('schedule')->latest()->limit(1)->get();
        return /*$schedule->schedule[0]->time_out*/$schedule[0]->schedule->time_out;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lastbreak  $lastbreak
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lastbreak $lastbreak)
    {
        //
    }
}
