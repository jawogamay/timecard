<?php

namespace App\Http\Controllers;

use App\Firstbreak;
use App\Timecard;
use App\UserInfo;
use Auth;
use Illuminate\Http\Request;
class FirstbreakController extends Controller
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
        return Firstbreak::where('userinfo_id',Auth::user()->id)->latest()->limit(1)->get();
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
    public function getFirstBreakAll(Request $request){
         $from = date($request['date_from']);
        $to = date($request['date_to']);
        return Firstbreak::with('userinfo.user')->whereBetween('created_at',[$from.' 00:00:00',$to.' 23:59:59'])->latest()->get(); 
    }
    public function getRealtimeFirstBreak(){
        return Firstbreak::whereBetween('created_at', [now()->subHours(12).' 00:00:00', now().' 23:59:59'])->with('userinfo.user')->latest()->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Get the Schedule Id to Determine if he is Overbreak
        $user = UserInfo::where('user_id',Auth::user()->id)->latest()->limit(1)->get();
       $schedule = $user->first()->schedule_id;
       //Store First Break in Database
        Firstbreak::create([
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
     * @param  \App\Firstbreak  $firstbreak
     * @return \Illuminate\Http\Response
     */
    public function show(Firstbreak $firstbreak)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Firstbreak  $firstbreak
     * @return \Illuminate\Http\Response
     */
    public function edit(Firstbreak $firstbreak)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Firstbreak  $firstbreak
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Firstbreak $firstbreak)
    {
        //
        $break = Firstbreak::findOrFail($firstbreak->id);
        $break->update([
            'stopped_at' => NOW()
        ]);

        $timecard = Timecard::findOrFail($break->timecard_id);
        $timecard->update([
            'is_working' => TRUE,
            'done_fbreak' => TRUE
        ]);
        $schedule = $break->with('schedule')->latest()->limit(1)->get();
        return /*$schedule->schedule[0]->time_out*/$schedule[0]->schedule->time_out;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Firstbreak  $firstbreak
     * @return \Illuminate\Http\Response
     */
    public function destroy(Firstbreak $firstbreak)
    {
        //
    }
}
