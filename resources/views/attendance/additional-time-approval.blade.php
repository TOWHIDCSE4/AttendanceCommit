@extends('MasterPage')
@section('title')
    {{__('AttendanceRecord\AdditionalTimeApproval.AdditionalTimeApprovalTitle')}}
@endsection
@section('content')
    <script>
        $( function() {
            $( "#datepicker1" ).datepicker({
                // startDate: "today",
                format:'yyyy-mm-dd',
                autoclose: true,
                orientation: "top",
                endDate: "today"
            });
            $( "#datepicker2" ).datepicker({
                // startDate: "today",
                format:'yyyy-mm-dd',
                autoclose: true,
                orientation: "top",
                endDate: "today"
            });
        } );
        function check() {
            var date1 = document.getElementById('datepicker1').value;
            var date2 = document.getElementById('datepicker2').value;
            if(date1!="" && date2!=""){
                if(date1 > date2){
                    document.getElementById('datepicker1').value = "";
                    document.getElementById('datepicker2').value = "";
                    alert('{{ __('Overtime\Approval.m01') }}');
                }
            }
        }
        function submitForm(){
            $('#ApprovalSearch_form').submit();
        }
    </script>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-info">
                    <center> <div class="card-header bg-info">{{__('AttendanceRecord\AdditionalTimeApproval.AdditionalTimeApprovalTitle')}}</div></center>


                    <div>

                        <div class="controls">
                            <form action="{{ url('/ApprovalSearch') }}" id="ApprovalSearch_form">
                                <div class="row justify-content-center">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="form_name">{{__('AttendanceRecord\AdditionalTimeApproval.UserID')}}</label>
                                            <input  type="text" autocomplete="off" name="user_id" class="form-control" placeholder="" value="{{ isset($user_id)?$user_id:'' }}"  data-error="UserID is required.">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>


                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="">{{__('AttendanceRecord\AdditionalTimeApproval.UserName')}}</label>
                                            <input  type="text" autocomplete="off" name="user_name" class="form-control" placeholder=""  value="{{ isset($user_name)?$user_name:'' }}"  data-error="UserName is required.">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row justify-content-center">
                                    <div class="col-md-5">
                                        <div class="form-group" >
                                            <label for="">{{__('AttendanceRecord\AdditionalTimeApproval.fromDate')}} </label>
                                            <input  type="text" id="datepicker1" name="FromDate" class="form-control" readonly onchange="check()" style="background-color: white;">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-5">
                                        <div class="form-group" >
                                            <label for="">{{__('AttendanceRecord\AdditionalTimeApproval.toDate')}} </label>
                                            <input  type="text" id="datepicker2" name="ToDate" class="form-control" readonly onchange="check();" style="background-color: white;">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </div>


                            </form>

                            <div class="row justify-content-center">
                                <div class="col-md-5">
                                    <div class="form-group" >
                                        <button class="btn btn-info" onclick="submitForm()" type="submit">{{__('AttendanceRecord\AdditionalTimeApproval.SearchButton')}}</button>
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="form-group" >
                                        <form action="{{ url('/additionalTime_ApprovalAll/') }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-info">{{__('AttendanceRecord\AdditionalTimeApproval.approvalAllButton')}}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>


                        </div>



                        <div class="card-body">
                            <table class="table table-hover table-bordered"  style="text-align: center">
                                <thead>
                                <tr>
                                    <th style="text-align: center">{{__('AttendanceRecord\AdditionalTimeApproval.date')}}</th>
                                    <th style="text-align: center">{{__('AttendanceRecord\AdditionalTimeApproval.UserName')}}</th>
                                    <th style="text-align: center">{{__('AttendanceRecord\AdditionalTimeApproval.checkIn')}}</th>
                                    <th style="text-align: center">{{__('AttendanceRecord\AdditionalTimeApproval.checkOut')}} </th>
                                    <th style="text-align: center">{{__('AttendanceRecord\AdditionalTimeApproval.BreakTime')}}</th>
                                    <th style="text-align: center">{{__('AttendanceRecord\AdditionalTimeApproval.Duration')}} </th>
                                    {{--                                    <th style="text-align: center">Status </th>--}}
                                    <th style="text-align: center" colspan="2">{{__('AttendanceRecord\AdditionalTimeApproval.acton')}}</th>

                                    <!--  <th style="text-align: center">Status</th>
                                      <th style="text-align: center">説明</th>    --->
                                </tr>
                                </thead>
                                <tbody>
                                {{--                                @foreach($daily_attendance_record as $row)--}}
                                @for($i=0;$i<count($daily_attendance_record);$i++)
                                    <tr>
                                        <td>
                                            {{--                                            {{ $row->date }}--}}
                                            {{ $daily_attendance_record[$i]['date'] }}
                                        </td>
                                        <td>
                                            {{--                                            {{ $row->user_name }}--}}
                                            {{ $daily_attendance_record[$i]['user_name'] }}
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($daily_attendance_record[$i]['checkin'])->format('H:i') }}
                                        </td>
                                        <td>
                                        {{ \Carbon\Carbon::parse($daily_attendance_record[$i]['checkout'])->format('H:i') }}
                                        <td>
                                            {{ $daily_attendance_record[$i]['break_time_hour'] }}
                                        </td>
                                        <td>
                                            {{ $daily_attendance_record[$i]['total_working_hour'] }}
                                        </td>
                                        {{--                                        <td>{{ $row->overtime_id }}</td>--}}
                                        {{--                                        <td>{{ $row->status }}</td>--}}

                                        <td>
                                            <form action="{{ url('/Additional_change/approve/'.$daily_attendance_record[$i]['daily_attendance_id']) }}">
                                                <button type="submit" class="btn btn-info"  >{{__('AttendanceRecord\AdditionalTimeApproval.approval')}}</button>
                                            </form>
                                        </td>
                                        <td>
                                            <form  action="{{ url('/Additional_change/reject/'.$daily_attendance_record[$i]['daily_attendance_id']) }}">
                                                <button type="submit" class="btn btn-info" >{{__('AttendanceRecord\AdditionalTimeApproval.reject')}}</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endfor
                                {{--                                @endforeach--}}
                                </tbody>






                            </table>
                            <input type="hidden" id="hid" value="{{ isset($id)?$id:'' }}">
                            {{--                            <div class="row">--}}
                            {{--                                <div class="col-md-1">--}}
                            {{--                                    <form action="{{ url('/UserCreation') }}"><button class="btn btn-info" type="submit">新規</button></form>--}}
                            {{--                                    --}}{{--                                    <ul class="pagination">--}}
                            {{--                                    --}}{{--                                    <li v-if="users.prev_page_url"><a @click.prevent="getUser(users.prev_page_url)" href="#">Previous</a></li>--}}
                            {{--                                    --}}{{--                                    <li v-if="users.next_page_url"><a @click.prevent="getUser(users.next_page_url)" href="#">Next</a></li>--}}
                            {{--                                    --}}{{--                                </ul>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
