@extends('MasterPage')
@section('title')
        {{__('Holiday\holidayApplication.title')}}
@endsection
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <link rel="stylesheet prefetch" href="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
    <style>
        #error{
            border-radius: 5px;
            z-index: 1000;
            margin-bottom: 30px;
            padding: 0;
        }

    </style>
    <script>
        $( function() {
            $( "#datepicker" ).datepicker({
                startDate: "today",
                format:'yyyy/mm/dd',
                autoclose: true
            });
            $( "#datepicker1" ).datepicker({
                startDate: "today",
                format:'yyyy/mm/dd',
                autoclose: true
            });
            $("#close").click(function(){
                $("#error").hide();
            });
        } );
        function checkDate() {
            var $from_date = document.getElementById('datepicker').value;
            var $to_date = document.getElementById('datepicker1').value;
            if($from_date==""){
                alert('{{__('Holiday\holidayApplication.M01')}}');
                document.getElementById('datepicker').focus();
                return false;
            }
            if($to_date==""){
                alert('{{__('Holiday\holidayApplication.M02')}}');
                document.getElementById('datepicker1').focus();
                return false;
            }
            var $start_date=new Date($from_date);
            var $end_date=new Date($to_date);
            if ($start_date>$end_date)
            {
                alert('{{__('Holiday\holidayApplication.M03')}}');
                return false;
            }
            return true;
        }
    </script>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    ​
                    ​
                    @if ($errors->any())
                        <div id="error" class="col-md-12">
                            <div class="alert alert-primary alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}
                                    @endforeach
                                </strong>
                            </div>
                        </div>
                    @endif
                    ​
                    ​
                    ​
                    <div class="card border-info">
                        <div class="card-header bg-info">{{__('Holiday\holidayApplication.title')}}</div>
                        <div class="card-body">
                            <form action="{{ url('/holiday_apply') }}" method="post" onsubmit="return checkDate()">
                                @csrf
                                <div class="row justify-content-center">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="form_need">{{__('Holiday\holidayApplication.holidayType')}} *</label>
                                            <select id="form_need" name="holiday_name" class="form-control" required="required" data-error="Please specify your need.">
                                                @foreach($holiday_type as $row)
                                                    <option value='{{ $row->holiday_id }}'>{{ $row->holiday_name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                ​
                                ​
                                <div class="row justify-content-center">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="form_lastname">{{__('Holiday\holidayApplication.from')}} *</label>
                                            <div class="form-group">
                                                    <input class="form-control" name="start_date" id="datepicker" readonly placeholder="YYYY/MM/DD" style="background-color: white;" type="text"/>
                                            </div>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    ​<div class="col-md-2"></div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="form_lastname">{{__('Holiday\holidayApplication.to')}} *</label>
                                            <div class="form-group">
                                                <input class="form-control" name="end_date" id="datepicker1" readonly placeholder="YYYY/MM/DD" style="background-color: white;" type="text"/>
                                            </div>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                ​
                                ​
                                <div class="row justify-content-center">
                                    <div class="col-md-2"><button class="btn btn-info" type="submit">{{__('Holiday\holidayApplication.btnRegister')}}</button></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
