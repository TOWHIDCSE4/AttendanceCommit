<!DOCTYPE html>
<html>
@extends('MasterPage')
@section('title')
    {{ __('Overtime\Application.title') }}
@endsection
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <link rel="stylesheet prefetch" href="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
    <script>
        $( function() {
            $( "#datepicker" ).datepicker({
                startDate: "+1d",
                format:'yyyy/mm/dd',
                autoclose: true
            });
        } );

    </script>
    <style>
        @media ( max-width: 800px){
            .card{
                bottom: 50px;
                width: 100%;
                /*padding: 5px;*/
            }
        }
    </style>
    <body>
    <div class="wrapper">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    @if ($errors->any())
                        <div class="alert alert-info alert-dismissible" style="border-radius: 5px; z-index: 1000; margin-bottom: 60px;">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>
                                @foreach ($errors->all() as $error)
                                    {{ $error }}
                                    <input type="hidden" id="error_value" value="{{ $error }}">
                                @endforeach
                            </strong>
                        </div>
                    @endif
                    <div class="card border-info">
                        <div class="card-header bg-info">{{ __('Overtime\Application.title') }}</div>
                        <div class="card-body">
                            <form action="{{ url('/overtime_apply') }}" method="POST" onsubmit="return check_error()">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3">{{ __('Overtime\Application.date') }}: </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input class="form-control" readonly name="date_request" id="datepicker" type="text" style="background-color: white;"/>
                                        </div>
                                    </div>
                                </div><br>
                                <div class="row">
                                    <div class="col-md-3">{{ __('Overtime\Application.duration') }}: </div>
                                    <div class="col-lg-9">
                                        <div class="row">
                                            <div class="col-xs-1 time_select">
                                                <select name="hour_apply" id="hour_apply" class="custom_time_select">
                                                    @for($i=00;$i<=23;$i++)
                                                        <option value="{{ $i }}">
                                                            @if($i<10) {{0}}@endif{{$i }}
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>&nbsp;&nbsp;
                                            <div class="col-xs-1 time_select">
                                                <select name="min_apply" id="min_apply" class="custom_time_select">
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
                                    <div class="col-md-3">{{ __('Overtime\Application.checkout') }}: </div>
                                    <div class="col-lg-9">
                                        <div class="row">
                                            <div class="col-xs-1 time_select">
                                                <select name="hour_checkout" id="hour_checkout" class="custom_time_select">
                                                    @for($i=00;$i<=23;$i++)
                                                        <option value="{{ $i }}">
                                                            @if($i<10) {{0}}@endif{{$i }}
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>&nbsp;&nbsp;
                                            <div class="col-xs-1 time_select">
                                                <select name="min_checkout" id="min_checkout" class="custom_time_select">
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
                                    <div class="col-md-3">{{ __('Overtime\Application.reason') }}: </div>
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <div class='input-group date' id='reason'>
                                                <input type='text' name="reason_apply" id="reason_apply" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                </div><br>
                                <div class="row">
                                    <div class="col-lg-4"></div>
                                    <div class="col-lg-8">
                                        <button class="btn btn-info" type="submit">{{ __('Overtime\Application.register_btn') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function check_error(){
            var date = document.getElementById('datepicker').value;
            var hour = document.getElementById('hour_apply').value;
            var min = document.getElementById('min_apply').value;
            var hour_checkout = document.getElementById('hour_checkout').value;
            var min_checkout = document.getElementById('min_checkout').value;
            var reason = document.getElementById('reason_apply').value;
            if(date.length <= 0){
                alert('{{ __('Overtime\Application.M006') }}');
                document.getElementById('datepicker').focus();
                return false;
            }
            if(hour <= 0 && min <= 0){
                alert('{{ __('Overtime\Application.M007') }}');
                document.getElementById('hour_apply').focus();
                return false;
            }
            if(hour_checkout <= 0 && min_checkout <= 0){
                alert('{{ __('Overtime\Application.M008') }}');
                document.getElementById('hour_checkout').focus();
                return false;
            }
            if (reason.length <= 0) {
                alert('{{ __('Overtime\Application.M009') }}');
                document.getElementById('reason_apply').focus();
                return false;
            }
        }
    </script>
    </body>
</html>
@endsection