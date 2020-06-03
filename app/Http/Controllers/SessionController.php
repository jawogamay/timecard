<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
class SessionController extends Controller
{
    //
    public function autoLogout(){
        return Auth::logout();
    }
}
