@extends('MasterPage')
@section('title')
    {{ __('WorkTimeAMonth\OneMonthWorkingTime.title1') }}
@endsection
@section('content')
    <script>
        $( function() {
            $( "#datepicker" ).datepicker({
                format: "mm-yyyy",
                startView: "months",
                minViewMode: "months",
                autoclose: true
            });
            $("#close").click(function(){
                $("#error").hide();
            });
        } );
    </script>
    <style type="text/css">
        @media screen and (max-width: 1050px){
            .wrapper{
                padding-right: 20px;
            }
            .card{
                width: 120%;
            }
            .wrapper table{
                width: 100%;
                padding: 5px;
            }
            .wrapper table tr td{
                padding: 5px;
                font-size: 14px;
            }
        }
        @media screen and (max-width: 920px){
            .wrapper{
                padding-right: 20px;
            }
            .card{
                width: 135%;
                left: -50px;
            }
        }
        @media screen and (max-width: 830px){
            .wrapper{
                padding-right: 20px;
            }
            .card{
                width: 150%;
                left: -20%;
            }
        }
        @media screen and (max-width: 768px){
            .wrapper{
                padding-right: 20px;
            }
            .card{
                width: 185%;
                left: -10px;
            }
            #btn_search{
                margin-top: 10px;
            }
        }
    </style>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card border-info">
                        <div class="card-header bg-info">{{ __('WorkTimeAMonth\OneMonthWorkingTime.title1') }}</div>
                        <div class="card-body">
                            <form action="{{ url('/oneMonthApprovalSearch') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-1">{{ __('WorkTimeAMonth\OneMonthWorkingTime.month') }}:</div>
                                    <div class="col-md-3">
                                        <input class="form-control" name="date_search" id="datepicker" readonly style="background-color: white" type="text"/>
                                    </div>
                                    <div class="col-md-1"></div>
                                    <div class="col-md-2">{{ __('WorkTimeAMonth\OneMonthWorkingTime.id') }}:</div>
                                    <div class="col-md-3"><input type="text" name="id_search" class="form-control" id="" value="{{ isset($id)?$id:'' }}"></div>
                                </div><br>
                                <div class="row">
                                    <div class="col-md-1">{{ __('WorkTimeAMonth\OneMonthWorkingTime.status') }}:</div>
                                    <div class="col-md-3">
                                        <select name="status_search" id="" class="form-control">
                                            <option value=""></option>
                                            <option value="approve">Approve</option>
                                            <option value="reject">Reject</option>
                                            <option value="pending">Pending</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1"></div>
                                    <div class="col-md-2">{{ __('WorkTimeAMonth\OneMonthWorkingTime.name') }}:</div>
                                    <div class="col-md-3"><input type="text" name="name_search" class="form-control" id="" value="{{ isset($name)?$name:'' }}"></div>
                                    <div class="col-md-2" style="text-align: center;" id="btn_search"><button class="btn btn-info">{{ __('WorkTimeAMonth\OneMonthWorkingTime.btn_search') }}</button></div>
                                </div>
                            </form>
                            <p></p> <br>
                            <table class="table table-hover table-bordered"  style="text-align: center">
                                <thead>
                                <tr>
                                    <th  style="text-align: center">{{ __('WorkTimeAMonth\OneMonthWorkingTime.name') }}</th>
                                    <th  style="text-align: center">{{ __('WorkTimeAMonth\OneMonthWorkingTime.time') }}</th>
                                    <th  style="text-align: center">{{ __('WorkTimeAMonth\OneMonthWorkingTime.duration1') }}</th>
                                    <th colspan="3"  style="text-align: center">{{ __('WorkTimeAMonth\OneMonthWorkingTime.action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @for($i = 0; $i < count($one_month); $i++)
                                    <tr>
                                        <td>
                                            {{ $one_month[$i]['user_name'] }}
                                        </td>
                                        <td>
                                            {{ $one_month[$i]['start_date'].' ~ '.$one_month[$i]['end_date'] }}
                                        </td>
                                        <td>
                                            {{ $one_month[$i]['total'] }}
                                        </td>
                                        <td>
                                            <form action="{{ url('/doApproveWorkTime/approve/'.$one_month[$i]['one_month_id']) }}">
                                                <button class="btn btn-info">{{ __('WorkTimeAMonth\OneMonthWorkingTime.btn_approve') }}</button>
                                            </form>
                                        </td>
                                        <td>
                                            <form action="{{ url('/doApproveWorkTime/reject/'.$one_month[$i]['one_month_id']) }}">
                                                <button class="btn btn-info">{{ __('WorkTimeAMonth\OneMonthWorkingTime.btn_reject') }}</button>
                                            </form>
                                        </td>
                                        <td>
                                            <form action="{{ url('/one_month_detail/'.$one_month[$i]['user_id'].'/'.$one_month[$i]['start_date'].'/'.$one_month[$i]['end_date'].'/'.$one_month[$i]['one_month_id']) }}">
                                                <button class="btn btn-info">{{ __('WorkTimeAMonth\OneMonthWorkingTime.btn_detail') }}</button>
                                            </form>
                                        </td>
                                    </tr>
                                </tbody>
                                @endfor
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

