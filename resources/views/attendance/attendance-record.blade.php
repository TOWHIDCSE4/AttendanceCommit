{{--@include('MasterPage')--}}
@extends('MasterPage')
@section('title')
    {{__('AttendanceRecord\AttendanceRecord.AttendanceRecord')}}
@endsection
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet prefetch" href="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
    <script>                                                                                                                       {{--    Date datepicker using Javascript --}}
        $( function() {
            $( "#datepicker" ).datepicker({
                // startDate: "today",
                format:"yyyy-mm",
                startView: "months",
                minViewMode: "months",
                autoclose: true
            });
            $("#close").click(function(){
                $("#error").hide();

            });
        } );
        // Confirm Check IN time and Check Out time
        function CheckOutSure() {
            var c = document.getElementById('btn1');
            if(c.getAttribute('disabled')!='disabled')
            {
                alert ('you need check in before ');
                return false;
            }else{
                $confirm_checkout = $('#confirm_checkout');
                $confirm_checkout[0].showModal();
                $('#cancel').on('click', function() {
                    $confirm_checkout[0].close();
                });
            }
        }
        // Reload go to attendance Record
        function myFunction() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("datepicker");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
            input.value = "";
        }


    </script>
    <style>
        /*using for calendar */
        #error{
            background-color: #c3d9f1;
            height: 50px;
            line-height: 50px;
        }
        #close{
            border-radius: 20px;
        }
        #close_btn{
            font-size: 16px;
            color: white;
        }
    </style>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    {{--For dialog message close --}}
                    @if ($errors->any())
                        <div id="error" class="col-lg-12" style="border-radius: 5px;">
                            <div class="row">
                                <div class="col-lg-11">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}
                                    @endforeach
                                </div>
                                <div class="col-lg-1" style="float: right;">
                                    <button onclick="close()" id="close" class="btn btn-info">                                                {{--For dialog message close --}}
                                        <i id="close_btn">&times;</i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif


                    <div class="card border-info">
                        <center> <div class="card-header bg-info">{{__('AttendanceRecord\AttendanceRecord.AttendanceRecord')}}</div></center>            {{--Heading Attendance Record --}}



                        <div class="card-body">
                            <div>
                                <div class="controls">
                                    {{--                                <form action=""> --}}

                                    <div class="row">
                                        <div class="col-md-4"> </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <div id="" class="input-group date">
                                                    <input class="form-control" name="date" id="datepicker" placeholder="{{__('AttendanceRecord\AttendanceRecord.SelectMonthYearIdplaceholder')}}" autocomplete="off"  type="text"/>                    {{--placeholder Select Year and month --}}
                                                    <button type="button" class="btn btn-info" onclick="myFunction()">Search</button>
                                                </div>
                                            </div>
                                        </div>
{{--                                        <div class="col-md-5">--}}
{{--                                            <button class="btn btn-info" type="Search" onclick="myFunction()" style="margin-left: 36px;">--}}
{{--                                                {{__('AttendanceRecord\AttendanceRecord.searchButton')}}--}}
{{--                                            </button>--}}
{{--                                        </div>                                               --}}{{--Search Button  --}}
                                    </div>

                                    {{--                                </form>--}}
                                </div>
                            </div>
                            <table class="table table-hover table-bordered" id="myTable" style="text-align: center">
                                <thead>
                                <tr>
                                    <th style="text-align: center">{{__('AttendanceRecord\AttendanceRecord.Date')}}</th>                                                                           {{--Table Heading Date --}}
                                    <th style="text-align: center">{{__('AttendanceRecord\AttendanceRecord.CheckIn')}}</th>                                                                        {{--Table Heading Check In --}}
                                    <th style="text-align: center">{{__('AttendanceRecord\AttendanceRecord.CheckOut')}} </th>                                                                      {{--Table Heading Check Out --}}
                                    <th style="text-align: center">{{__('AttendanceRecord\AttendanceRecord.BreakTime')}}</th>                                                                      {{--Table Heading Break Time --}}
                                    <th style="text-align: center">{{__('AttendanceRecord\AttendanceRecord.Duration')}} </th>                                                                      {{--Table Heading Duration --}}
                                    <th style="text-align: center">{{__('AttendanceRecord\AttendanceRecord.OverTime')}} </th>                                                                      {{--Table Heading Over time --}}

                                {{--                                <th style="text-align: center" colspan="2">Action</th>--}}

                                <!--  <th style="text-align: center">Status</th>
                                  <th style="text-align: center">説明</th>    --->
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($daily_attendance_record as $row)

                                    <tr>
                                        <td>{{ $row->date }}</td>
                                        {{--                                    <td>{{ $row->user_name }}</td>--}}
                                        <td>{{ \Carbon\Carbon::parse($row->checkin)->format('H:i') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($row->checkout)->format('H:i') }}</td>
                                        <td>{{ $row->break_time_hour }}</td>
                                        <td>{{ $row->total_working_hour }}</td>
                                        <td>{{ isset($row->duration)?$row->duration:'0' }}</td>
                                    {{--                                    <td>{{ $row->status }}</td>--}}



                                @endforeach
                                </tbody>

                            </table>


                            <dialog id="confirm_checkout" class="site-dialog">
                                <header class="dialog-header">
                                    <h1>{{__('AttendanceRecord\AttendanceRecord.dialog')}}</h1>                                                                        {{--dialog for Check out time Yes or No --}}
                                </header>
                                <div class="">
                                    <form action="{{ url('/CheckoutUpdate/') }}" id="form_delete">
                                        <div class="col-md-12">
                                            <div class="row justify-content-center">
                                                <button class="btn btn-info" value="" name="btn_yes" type="submit" id="agree">{{__('AttendanceRecord\AttendanceRecord.yes')}}</button> &nbsp; &nbsp;
                                                <button class="btn btn-info" value="" name="btn_no" id="cancel" type="button">{{__('AttendanceRecord\AttendanceRecord.no')}}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </dialog>



                            <input type="hidden" id="hid" value="{{ isset($id)?$id:'' }}">
                            <div class="row justify-content-center">
                                <div class="col-md-5">
                                    <div class="row justify-content-center">
                                        <form action="{{ url('/CheckinInsert') }}"><div class="col-md-5"><button class="btn btn-info" id="btn1" style="@if(isset($form_type) && $form_type=='search') display: none; @endif" value="checkIn" @if(isset($Disable_checkin)&&$Disable_checkin!='') disabled="disabled" @endif  type="checkIn">{{__('AttendanceRecord\AttendanceRecord.CheckIn')}}</button></div></form>
                                        {{--                                    <form action="{{ url('/CheckoutUpdate') }}">--}}
                                        <div class="col-md-5"><button class="btn btn-info"  style="@if(isset($form_type) && $form_type=='search') display: none; @endif"  @if(isset($Disable_checkout)&&$Disable_checkout!='') disabled @endif onclick="CheckOutSure()" type="checkout">{{__('AttendanceRecord\AttendanceRecord.CheckOut')}}</button></div>
                                        {{--                                    </form>--}}
                                    </div>
                                </div>

                                <form action="{{ url('/additional_time_request') }}"><button class="btn btn-info" style="@if(isset($form_type) && $form_type=='search') display: none; @endif" type="registration">{{__('AttendanceRecord\AttendanceRecord.AdditionalTimeRequestButton')}}</button></form>                           {{-- Button AdditionalTimeRequestButton --}}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection