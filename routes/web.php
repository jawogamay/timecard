<?php



Route::get('/', function () {
    return view('welcome');
});
Route::get('/ip',function(){
    return request()->ip();
});
Auth::routes([
  'register' => false, // Registration Routes...
  'reset' => false, // Password Reset Routes...
  'verify' => false, // Email Verification Routes...
]);


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/timecard','TimecardController@index');
Route::get('/users','UserController@index');
Route::any('/updatetimecard/{id}','TimecardController@update');
Route::get('/authlogout','SessionController@autoLogout');
Route::get('/getSchedule','UserInfoController@getSchedule');
Route::apiResources(['/others'=>'OtherController']);
Route::get('/getAllLastbreak','LastbreakController@getAllLastbreak');
Route::get('/getAlllunchbreak','LunchbreakController@getAlllunchbreak');
Route::get('/getRealtimeFirstBreak','FirstbreakController@getRealtimeFirstBreak');
Route::get('/othersall','OtherController@getAllOthers');
Route::get('/export','TimecardController@export');
Route::apiResources(['firstbreak' => 'FirstbreakController']);
Route::apiResources(['timecard' => 'TimecardController']);
Route::apiResources(['lunchbreak' => 'LunchbreakController']);
Route::apiResources(['lastbreak' => 'LastbreakController']);
Route::apiResources(['schedule' => 'ScheduleController']);
Route::apiResources(['idle' => 'IdleController']);
Route::get('getAllUserInfo','UserInfoController@getAllUserInfo');
Route::post('logoutclock','IdleController@clockLogout');
Route::get('getFirstBreakAll','FirstbreakController@getFirstBreakAll');
Route::post('/userinfo','UserInfoController@store');
Route::get('/reactivateTimecard','TimecardController@reactivateTimecard');
Route::any('/reactivateUser/{id}','TimecardController@reactivateUser');
Route::get('getTimecardAll','TimecardController@getTimecardAll');
Route::get('getRealtime','TimecardController@getRealtime');
Route::get('/{path}',"HomeController@index")->where( 'path', '.*' );
