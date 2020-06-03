<?php

namespace App\Http\Controllers;

use App\Other;
use App\Timecard;
use Auth;
use Illuminate\Http\Request;
class OtherController extends Controller
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
        return Other::with('userinfo.user')->where('userinfo_id',Auth::user()->id)->latest()->get();
    }
    public function getAllOthers(Request $request){
       $from = date($request['date_from']);
        $to = date($request['date_to']);
        return Other::with('userinfo.user')->whereBetween('created_at',[$from.' 00:00:00',$to.' 23:59:59'])->latest()->get(); 
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
        $this->validate($request,[
            'description' => 'required'
        ]);
        Other::create([
            'name' => $request['description'],
            'userinfo_id' => Auth::user()->id,
            'started_at' => NOW(),
            'timecard_id' => $request['timecard_id']
        ]);
        
        return 'Success';
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Other  $other
     * @return \Illuminate\Http\Response
     */
    public function show(Other $other)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Other  $other
     * @return \Illuminate\Http\Response
     */
    public function edit(Other $other)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Other  $other
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Other $other)
    {
        //
        $oth = Other::findOrFail($other->id);
        $oth->update([
            'stopped_at' => NOW()
        ]);
        $timecard = Timecard::findOrFail($oth->timecard_id);
        $timecard->update([
            'is_working' => TRUE,
        ]);
        return 'Hey';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Other  $other
     * @return \Illuminate\Http\Response
     */
    public function destroy(Other $other)
    {
        //
    }
}
