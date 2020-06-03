<?php

namespace App\Http\Controllers;

use App\Schedule;
use App\UserInfo;
use Illuminate\Http\Request;

class UserInfoController extends Controller
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
        return User::all();
    }

    //Get Schedule Select
    public function getSchedule()
    {
        return Schedule::all();
    }
    public function getAllUserInfo(){
        return UserInfo::with(['user','schedule'])->latest()->get();
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
        //Validate the data
        $this->validate($request,[
            'user' => 'required',
            'schedule' => 'required',
            'position' => 'required',
            'department' => 'required',
            'details' => 'required'
        ]);

        UserInfo::create([
            'user_id' => $request['user'],
            'schedule_id' => $request['schedule'],
            'department' => $request['department'],
            'position' => $request['position'],
            'details' => $request['details']
        ]);
        return 'Success';
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserInfo  $userInfo
     * @return \Illuminate\Http\Response
     */
    public function show(UserInfo $userInfo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserInfo  $userInfo
     * @return \Illuminate\Http\Response
     */
    public function edit(UserInfo $userInfo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserInfo  $userInfo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserInfo $userInfo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserInfo  $userInfo
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserInfo $userInfo)
    {
        //
    }
}
