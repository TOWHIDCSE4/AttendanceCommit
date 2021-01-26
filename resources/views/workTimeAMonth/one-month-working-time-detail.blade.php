@extends('MasterPage')
@section('title')
    {{ __('WorkTimeAMonth\OneMonthWorkingTime.title2') }}
@endsection
@section('content')
    <script>
        $( function() {
            $( "#datepicker" ).datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });
            $("#close").click(function(){
                $("#error").hide();
            });
        } );
        function myFunction1() {
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
    <style type="text/css">
        @media screen and (max-width: 768px){
            .col-md-1{
                width: 50%;
                text-align: center;
            }
            .col-md-2{
                width: 50%;
                text-align: center;
            }
            .card{
                width: 200%;
            }
        }
    </style>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card border-info">
                        <div class="card-header bg-info">{{ __('WorkTimeAMonth\OneMonthWorkingTime.title2') }}</div>
                        <div class="card-body">
                            <div class="row">
                                {{--                            <form action="{{ url('/detailSearch') }}" onsubmit="return check_err()">--}}
                                <div class="col-md-4">{{ __('WorkTimeAMonth\OneMonthWorkingTime.date') }}:
                                    <input name="date_search" id="datepicker" readonly type="text"/><button class="btn-info" onclick="myFunction1()"><i class="fa fa-search"></i></button>
                                    <input type="hidden" name="monthly_attendance_id" value="{{ $monthly_attendance_id }}">
                                </div>
                                {{--                            </form>--}}
                            </div>
                            <p></p>
                            <table class="table table-hover table-bordered" id="myTable" style="text-align: center">
                                <thead>
                                <tr>
                                    <th style="text-align: center">{{ __('WorkTimeAMonth\OneMonthWorkingTime.date') }}</th>
                                    <th style="text-align: center">{{ __('WorkTimeAMonth\OneMonthWorkingTime.checkin') }}</th>
                                    <th style="text-align: center">{{ __('WorkTimeAMonth\OneMonthWorkingTime.checkout') }}</th>
                                    <th style="text-align: center">{{ __('WorkTimeAMonth\OneMonthWorkingTime.break_time') }}</th>
                                    <th style="text-align: center">{{ __('WorkTimeAMonth\OneMonthWorkingTime.overtime') }}</th>
                                    <th style="text-align: center">{{ __('WorkTimeAMonth\OneMonthWorkingTime.duration2') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($detail_record as $row)
                                    <tr>
                                        <td>{{ $row->date }}</td>
                                        <td>{{ \Carbon\Carbon::parse($row->checkin)->format('H:i') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($row->checkout)->format('H:i') }}</td>
                                        <td>{{ $row->break_time_hour }}</td>
                                        <td>{{ $row->duration }}</td>
                                        <td>{{ $row->total_working_hour }}</td>
                                    </tr>
                                </tbody>
                                @endforeach
                            </table>
                            <div class="row justify-content-between">
                                <div class="col-md-1">
                                    <form action="{{ url('/doApproveWorkTime/approve/'.$monthly_attendance_id) }}"><button class="btn btn-info" type="submit">{{ __('WorkTimeAMonth\OneMonthWorkingTime.btn_approve') }}</button></form>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-info"  onclick="window.history.go(-1); return false;">{{ __('WorkTimeAMonth\OneMonthWorkingTime.btn_cancel') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

