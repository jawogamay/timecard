<?php

namespace App\Http\Controllers;

use App\Exports\TimecardExport;
use App\Schedule;
use App\Timecard;
use App\UserInfo;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
class TimecardController extends Controller
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
        return Timecard::where('userinfo_id',Auth::user()->id)->latest()->limit(1)->get();
    }
    public function getTimecardAll(Request $request){
        $from = date($request['date_from']);
        $to = date($request['date_to']);
        return Timecard::with('userinfo.user')->whereBetween('created_at',[$from.' 00:00:00',$to.' 23:59:59'])->latest()->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request){
       
         $from = date($request['date_from']);
        $to = date($request['date_to']);
      return (new TimecardExport)->between($from,$to)->download('reports.xlsx');
    }
    public function create()
    {
        //
    }
    public function reactivateTimecard(){
         return Timecard::whereBetween('updated_at', [now()->subHours(1), now()])->where('time_out','!=',null)->with(['userinfo.user','userinfo.schedule'])->get();
    }

    public function reactivateUser($id){
        $reactivate = Timecard::findOrFail($id);
        $reactivate->update([
            'time_out' => NULL,
            'is_working' => TRUE
        ]);
        return 'Success';
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getRealtime(){
        return Timecard::whereBetween('created_at', [now()->subHours(12), now()])->where('time_out',null)->with(['userinfo.user','userinfo.schedule'])->get();
    }
    public function store(Request $request)
    {
        //
        $schedule_id = UserInfo::findOrFail(Auth::user()->id);
        $time = Schedule::findOrFail($schedule_id->schedule_id);
        $date = Carbon::parse(NOW())->addHour(9);

        $givenTimestamp = strtotime(NOW());
        $time_in = strtotime($time->time_in);
        if($givenTimestamp>$time_in){
            Timecard::create([
            'time_in' => NOW(),
            'late_flag' => True,
            'userinfo_id' => Auth::user()->id,
            'is_working' => TRUE,
            'time_outexpire' => $date

        ]);
        }else{
            Timecard::create([
            'time_in' => NOW(),
            'userinfo_id' => Auth::user()->id,
            'is_working' => TRUE,
            'time_outexpire' => $date
        ]);
        }
    return 'success';
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Timecard  $timecard
     * @return \Illuminate\Http\Response
     */
    public function show(Timecard $timecard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Timecard  $timecard
     * @return \Illuminate\Http\Response
     */
    public function edit(Timecard $timecard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Timecard  $timecard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //
        $timecard = Timecard::findOrFail($id);
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
        return 'Success';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Timecard  $timecard
     * @return \Illuminate\Http\Response
     */
    public function destroy(Timecard $timecard)
    {
        //
    }
}
