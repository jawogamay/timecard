<?php

namespace App\Http\Controllers;

use App\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
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
        return Schedule::all();
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
        //Validates the form
        $this->validate($request,[
            'nameshift' => 'required',
            'timein' => 'required|date_format:H:i',
            'timeout' => 'required|date_format:H:i',
            'fbin' => 'required|date_format:H:i',
            'fbout' => 'required|date_format:H:i',
            'lunchin' => 'required|date_format:H:i',
            'lunchout' => 'required|date_format:H:i',
            'lbin' => 'required|date_format:H:i',
            'lbout' => 'required|date_format:H:i'
        ]);
        Schedule::create([
            'nameshift' => $request['nameshift'],
            'time_in' => $request['timein'],
            'time_out' => $request['timeout'],
            'lunch_in' => $request['lunchin'],
            'lunch_out' => $request['lunchout'],
            'fbreak_in' => $request['fbin'],
            'fbreak_out' => $request['fbout'],
            'last_in' => $request['lbin'],
            'last_out' => $request['lbout']
        ]);
        return 'Success';
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function show(Schedule $schedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function edit(Schedule $schedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Schedule $schedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule)
    {
        //
    }
}
