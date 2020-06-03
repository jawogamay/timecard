<?php

namespace App\Http\Controllers;

use App\Idle;
use App\Timecard;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
class IdleController extends Controller
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
        return Idle::with('user')->latest()->get();
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
        return Idle::create([
            'user_id' => Auth::user()->id
        ]);
    }
    public function clockLogout(){
        $timecardlatest = Timecard::latest()->first();
        if($timecardlatest->time_out == null){
          $timecard = Timecard::findOrFail($timecardlatest->id);
        $to =  Carbon::parse($timecard->time_in);
        $from = Carbon::parse($timecard->time_out);
        $diff_in_minutes = $to->diffInHours($from);
        if($diff_in_minutes > 9){
            $timecard->update([
                'time_out' => NOW(),
                'userinfo_id' => Auth::user()->id,
                'is_working' => FALSE,
                'hours' => 6,
                'minutes' => 360
            ]);
        }else{
            $timecard->update([
                'time_out' => NOW(),
                'userinfo_id' => Auth::user()->id,
                'work_flag' => TRUE,
                'is_working' => FALSE,
                'hours' =>  round($to->diffInMinutes($from)/60,2),
                'minutes' => $to->diffInMinutes($from)

            ]);
        }
        }else{

        }
        return Auth::logout();
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Idle  $idle
     * @return \Illuminate\Http\Response
     */
    public function show(Idle $idle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Idle  $idle
     * @return \Illuminate\Http\Response
     */
    public function edit(Idle $idle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Idle  $idle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Idle $idle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Idle  $idle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Idle $idle)
    {
        //
    }
}
