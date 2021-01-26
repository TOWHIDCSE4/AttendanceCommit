@extends('MasterPage')
@section('title')
    {{__('AttendanceRecord\AttendanceRecord.AdditionalTimeRequestTitle')}}
@endsection
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet prefetch" href="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>

    {{--    javascript use for datepicker--}}
    <script>
        $( function() {
            $( "#datepicker" ).datepicker({
                // startDate: "today",
                format:'yyyy-mm-dd',
                autoclose: true,
                orientation: "top",
                endDate: "today"
            });
            $("#close").click(function(){
                $("#error").hide();
            });
            document.getElementById('checkin_hour').value = "9";
            document.getElementById('checkin_min').value = "0";
            document.getElementById('checkout_hour').value = "18";
            document.getElementById('checkout_min').value = "0";
            document.getElementById('break_time_hour').value = "1";
            document.getElementById('break_time_min').value = "0";
        } );

        function check_er(){
            var date = document.getElementById('date').value;
            var checkin_hour = document.getElementById('checkin_hour').value;
            var checkin_min = document.getElementById('checkin_min').value;
            var checkout_hour = document.getElementById('checkout_hour').value;
            var checkout_min = document.getElementById('checkout_min').value;
            var break_time = document.getElementById('break_time_hour').value;

            if(date.length <= 0){
                alert('Please enter date');
                document.getElementById('date').focus();
                return false;
            }
            if(checkin_hour == 0 && checkin_min == 0){
                alert('Please enter checkin');
                document.getElementById('checkin_hour').focus();
                return false;
            }
            if(checkout_hour == 0 && checkout_min == 0){
                alert('Please enter checkout');
                document.getElementById('checkout_hour').focus();
                return false;
            }
            if (break_time.length <= 0) {
                alert('Please enter Break Time');
                document.getElementById('break_time_hour').focus();
                return false;
            }
        }
    </script>
    <style>
        /*CSS use for datepicker*/
        #error{
            height: 47px;
            line-height: 26px;
            text-align: center;
            margin-bottom: 50px;
        }
        #close{
            height: 56px;
            width: 56px;
            left: -130px;
        }
        #close_btn{
            font-size: 16px;
            color: white;
        }
    </style>
    <body>
        <div class="wrapper">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        @if ($errors->any())
                            <div class="row" id="error">
                                <div class="col-md-10">
                                    <div class="alert alert-danger" style="margin-left: 2px;left: 83px;margin-bottom: 0px;">
                                        @foreach ($errors->all() as $error)
                                            {{ $error }}
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-md-2" >
                                    <button onclick="close()" id="close" class="btn btn-danger">
                                        <i id="close_btn">&times;</i>
                                    </button>
                                </div>
                            </div>
                        @endif
                        <div class="card border-info">
                            <div class="card-header bg-info">{{__('AttendanceRecord\AttendanceRecord.AdditionalTimeRequestTitle')}}</div>                                              {{-- Additional time request Heading   --}}
                            <div class="card-body">
                                <form action="{{ url('/SaveAdditional_timeRequest') }}" method="post" onsubmit="return check_er()">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-3">{{__('AttendanceRecord\AttendanceRecord.Date')}} </div>                                                                      {{--   select date  --}}
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <div id="datepicker" class="input-group date">
                                                    <input class="form-control" name="date" id="date" autocomplete="off"  type="text"/>
                                                    <button type="button" class="btn btn-info"><i class="fa fa-calendar"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-md-3">{{__('AttendanceRecord\AttendanceRecord.CheckIn')}} </div>                                                                       {{-- select check out time   --}}
                                        <div class="col-lg-4">
                                            <div class="row">
                                                <div class="col-xs-4 time_select">
                                                    <select name="checkin_hour" id="checkin_hour" class="custom_time_select">
                                                        @for($i=00;$i<=23;$i++)
                                                            <option value="{{ $i }}">
                                                                @if($i<10) {{0}}@endif{{$i }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col-xs-3 time_select">
                                                    <select name="checkin_min" id="checkin_min" class="custom_time_select">
                                                        @for($i=00;$i<=59;$i++)
                                                            <option value="{{ $i }}">
                                                                @if($i<10) {{0}}@endif{{$i }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-md-3">{{__('AttendanceRecord\AttendanceRecord.CheckOut')}} </div>                                                                         {{-- select check out time   --}}
                                        <div class="col-lg-4">
                                            <div class="row">
                                                <div class="col-xs-4 time_select">
                                                    <select name="checkout_hour" id="checkout_hour" class="custom_time_select">
                                                        @for($i=00;$i<=23;$i++)
                                                            <option value="{{ $i }}">
                                                                @if($i<10) {{0}}@endif{{$i }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col-xs-3 time_select">
                                                    <select name="checkout_min" id="checkout_min" class="custom_time_select">
                                                        @for($i=00;$i<=59;$i++)
                                                            <option value="{{ $i }}">
                                                                @if($i<10) {{0}}@endif{{$i }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4"></div>
                                    </div><br>


                                    <div class="row">
                                        <div class="col-md-3">{{__('AttendanceRecord\AttendanceRecord.BreakTime')}} </div>                                                                       {{-- select break time   --}}
                                        <div class="col-lg-4">
                                            <div class="row">
                                                <div class="col-xs-4 time_select">
                                                    <select name="break_time_hour" id="break_time_hour" class="custom_time_select">
                                                        @for($i=00;$i<=02;$i++)
                                                            <option value="{{ $i }}">
                                                                @if($i<10) {{0}}@endif{{$i }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col-xs-3 time_select">
                                                    <select name="break_time_min" id="break_time_min" class="custom_time_select">
                                                        @for($i=00;$i<=59;$i++)
                                                            <option value="{{ $i }}">
                                                                @if($i<10) {{0}}@endif{{$i }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4"></div>
                                    </div><br>


                                    <div class="row">
                                        <div class="col-lg-4"></div>
                                        <div class="col-lg-8">
                                            <button class="btn btn-info" type="submit">{{__('AttendanceRecord\AttendanceRecord.Register')}}</button>                                                                                {{--  Register Button   --}}
                                            <button type="button" class="btn btn-success btn-send" onclick="window.history.go(-1); return false;">{{__('AttendanceRecord\AttendanceRecord.cancel')}}</button>                        {{-- Cancel Button    --}}
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
@endsection
