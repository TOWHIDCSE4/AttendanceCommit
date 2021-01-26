 <!doctype html>
<html lang="en">
<head>
    <title>@yield('title')</title>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}">
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-3.3.1.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <link rel="stylesheet prefetch" href="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>

    <script>
        function myFunction() {
            var x = document.getElementById("navbar");
            if (x.className === "sidenav") {
                x.className += " responsive";
            } else {
                x.className = "sidenav";
            }
        }
        window.onclick  = function(event){
            if(event.target == true){
                myFunction();
            }
        };
        window.onscroll = function() {scrollFunction()};
        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                document.getElementById("menu_right").style.display = "none";
            } else {
                document.getElementById("menu_right").style.display = "";
            }
        }
    </script>
</head>
<style>
    .sidenav .icon {
        display: none;
    }
    @media screen and (max-width: 1000px) {
        /*when screen size under 600px*/
        .sidenav li:not(:first-child){display: none;}
        .sidenav .icon {
            float: left;
            display: block;
            padding: 10px;
        }
        #menu_right li{
            width: 20%;
        }

        /*after click icon*/
        .sidenav .responsive {position: relative;}
        .sidenav.responsive .icon {
            position: absolute;
            top: 10px;
            left: 20px;
            padding: 0px;
        }
        .sidenav.responsive li {
            float: none;
            display: block;
            text-align: left;
        }
        .sidenav.responsive .icon_menu {
            padding-top: 10px;
            padding-bottom: 10px;
        }

    }
</style>
<body>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <nav class="navbar navbar-expand-md navbar-dark">
                    <div class="col-md-2 content" id="col-md-9">
                        <ul class="sidenav" id="navbar" style="display:block;">
                            <li class="icon_menu">
                                <a href="javascript:void(0);" class="icon" onclick="myFunction()">
                                    <i class="fa fa-bars"></i>
                                </a>
                            </li>
                            <li class="nav-item active" id="home1" style="@if(Session::get('authority')!=1) display: none;  @endif">
                                <a class="nav-link" href="{{ route('user.list') }}">
                                    {{ __('locale.home') }}
                                </a>
                            </li>
                            <li class="nav-item active" id="home2" style="@if(Session::get('authority')==1) display: none; @endif ">
                                <a class="nav-link" href="{{  route('attendance.record') }}">
                                    {{ __('locale.home') }}
                                </a>
                            </li>
                            <li class="nav-item active" style="@if(Session::get('authority')!=1) display: none;  @endif">
                                <a class="nav-link" href="{{ url('/department') }}">{{ __('locale.department') }}</a>
                            </li>
                            <li class="nav-item active" style="@if(Session::get('authority')!=1) display: none;  @endif">
                                <a class="nav-link" href="{{ route('user.list') }}">{{ __('locale.userList') }}</a>
                            </li>
                            <li class="nav-item active" style="@if(Session::get('authority')!=1) display: none;  @endif">
                                <a class="nav-link" href="{{ url('holiday_approval') }}">{{ __('locale.holidayApproval') }}</a>
                            </li>
                            <li class="nav-item active" style="@if(Session::get('authority')!=1) display: none;  @endif">
                                <a class="nav-link" href="{{ url('holiday_history') }}">{{ __('locale.holidayHistory') }}</a>
                            </li>

                            <li class="nav-item active" style="@if(Session::get('authority')==1) display: none; @endif">
                                <a class="nav-link" href="{{ route('attendance.record') }}">{{ __('locale.attendanceRecord') }}</a>
                            </li>
                            <li class="nav-item active" style="@if(Session::get('authority')==1) display: none; @endif">
                                <a class="nav-link" href="{{ url('holiday_application') }}">{{ __('locale.holidayApplication') }}</a>
                            </li>
                            <li class="nav-item active" style="@if(Session::get('authority')==1) display: none; @endif">
                                <a class="nav-link" href="{{ url('/overtime') }}">{{ __('locale.overtimeApplication') }}</a>
                            </li>

                            <li class="nav-item active" style="@if(Session::get('authority')!=2) display: none; @endif">
                                <a class="nav-link" href="{{ url('/one_month_approve') }}">{{ __('locale.oneMonthApproval') }}</a>
                            </li>
                            <li class="nav-item active" style="@if(Session::get('authority')!=2) display: none; @endif">
                                <a class="nav-link" href="{{ url('additional_approval') }}">{{ __('locale.additionalTimeApproval') }}</a>
                            </li>
                            <li class="nav-item active" style="@if(Session::get('authority')!=2) display: none; @endif">
                                <a class="nav-link" href="{{ url('overtime_approval') }}">{{ __('locale.overtimeApproval') }}</a>
                            </li>

                        </ul>
                    </div>
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-12" >
                                <ul class="navbar-nav" id="menu_right">
                                    <li class="nav-item">
                                        <button class="btn btn-info">{{ Session::get('user_name') }}</button>
                                        <table class="change_pass">
                                            <tr>
                                                <td rowspan="2"><img src="@if(Session::get('image_path')!=null) {{ 'images/'.Session::get('image_path') }} @else https://placehold.it/180 @endif" alt=""></td>
                                                <td style="color: white;">{{ Session::get('user_id') }}</td>
                                            </tr>
                                            <tr>
                                                <td><form action="{{ url('/profile_setting/') }}"><button type="submit">{{ __('locale.updateInformation') }}</button></form></td>
                                            </tr>
                                        </table>
                                    </li>
                                    <li class="nav-item">
                                        <form id="" action="{{ route('notification.index') }}">
                                            @csrf
                                            <button type="submit" class="btn btn-info"><i class="glyphicon glyphicon-bell"></i></button>
                                        </form>
                                    </li>
                                    <li class="nav-item">
                                        <!--temporary logout button-->
                                        <form id="" action="{{ route('logout') }}" method="POST" >
                                            @csrf
                                            <button type="submit" class="btn btn-info">{{ __('locale.logout') }}</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row justify-content-center" >
                            <div class="col-md-10" style="">
                                <div class="container">
                                {{----}}
                                    <div class="main">
                                        @yield('content')
                                    </div>
                                {{----}}
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>
</body>
</html>