@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row profile">
        <div class="col-md-3">
            <div class="profile-sidebar">
                <!-- SIDEBAR USERPIC -->
                <div class="profile-userpic">
                    <center>
                        <digital-clock :blink="true" :twelve-hour="true" :display-seconds="true"style="background:#000; color:#fff; padding:5px;    "/>
                    </center>
                    <img src="https://joshuajharris.com/assets/images/vector-profile.png" class="img-responsive" alt="">
                </div>
                <!-- END SIDEBAR USERPIC -->
                <!-- SIDEBAR USER TITLE -->
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name">
                        {{Auth::user()->name}}
                    </div>
                    <div class="profile-usertitle-job">
                        Developer
                    </div>
                </div>
                <!-- END SIDEBAR USER TITLE -->
                <!-- SIDEBAR BUTTONS -->
              {{--   <div class="profile-userbuttons">
                    <button type="button" class="btn btn-success btn-sm">Follow</button>
                    <button type="button" class="btn btn-danger btn-sm">Message</button>
                </div> --}}
                <!-- END SIDEBAR BUTTONS -->
                <!-- SIDEBAR MENU -->
                <div class="profile-usermenu">
                    <ul class="nav">
                        <li>
                            <router-link to="/home">
                                <i class="glyphicon glyphicon-home"></i>
                                Overview 
                            </router-link>
                        </li>
                        <li>
                            <router-link to="/userinfo">
                            <i class="glyphicon glyphicon-user"></i>
                            User Information </router-link>
                        </li>
                        <li>
                            <router-link to="/schedules" >
                            <i class="glyphicon glyphicon-calendar"></i>
                            Schedule </router-link>
                        </li>
                        <li>
                            <router-link to="/clocks" >
                            <i class="glyphicon glyphicon-calendar"></i>
                            Clocks </router-link>
                        </li>
                         <li>
                            <router-link to="/firstbreaklogs" >
                            <i class="glyphicon glyphicon-calendar"></i>
                            First Break </router-link>
                        </li>
                         <li>
                            <router-link to="/lunchbreaklogs" >
                            <i class="glyphicon glyphicon-calendar"></i>
                            Lunch Break </router-link>
                        </li>
                         <li>
                            <router-link to="/lastbreaklogs" >
                            <i class="glyphicon glyphicon-calendar"></i>
                            Last Break </router-link>
                        </li>
                         <li>
                            <router-link to="/otherslogs" >
                            <i class="glyphicon glyphicon-calendar"></i>
                            Others </router-link>
                        </li>
                          <li>
                            <router-link to="/idlelogs" >
                            <i class="glyphicon glyphicon-calendar"></i>
                            Idle </router-link>
                        </li>
                        <li>
                            <a href="#">
                            <i class="glyphicon glyphicon-flag"></i>
                            Help </a>
                        </li>
                        <li>
                            <a  href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();"
                            >
                            <i class="glyphicon glyphicon-off"></i>
                            Logout 
                            </a>
                             <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </div>
                <!-- END MENU -->
            </div>
        </div>
        <div class="col-md-9">
            <div class="profile-content">
               <router-view></router-view>
            </div>
        </div>
    </div>
</div>
<center>
<strong>Powered by <a href="https://www.newreadermagazine.com/" target="_blank">New Reader Magazine</a></strong>
</center>
@endsection
