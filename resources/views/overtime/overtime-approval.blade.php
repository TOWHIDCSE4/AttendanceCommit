@extends('MasterPage')
@section('title')
    {{ __('Overtime\Approval.title') }}
@endsection
@section('content')
    <script>
        $( function() {
            $( "#datepicker" ).datepicker({
                format: "yyyy-mm-dd",
                // startView: "months",
                // minViewMode: "months",
                autoclose: true
            });
            $( "#datepicker2" ).datepicker({
                format: "yyyy-mm-dd",
                // startView: "months",
                // minViewMode: "months",
                autoclose: true
            });
        } );
        function check() {
            var date1 = document.getElementById('datepicker').value;
            var date2 = document.getElementById('datepicker2').value;
            if(date1 > date2){
                document.getElementById('datepicker').value = "";
                document.getElementById('datepicker2').value = "";
                alert('{{ __('Overtime\Approval.m01') }}');
            }
        }
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
                width: 150%;
                font-size: 14px;
                left: 10px;
            }
            .card table tr td{
                font-size: 12px;
            }
            .card table tr  th{
                font-size: 12px;
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
                        <div class="card-header bg-info">{{ __('Overtime\Approval.title') }}</div>
                        <div class="card-body">
                            <form action="{{ url('/overtime_search') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-1">{{ __('Overtime\Approval.from') }}:</div>
                                    <div class="col-md-3">
                                        <input class="form-control" name="from_date" id="datepicker" readonly style="background-color: white" type="text"/>
                                    </div>
                                    <div class="col-md-1"></div>
                                    <div class="col-md-2">{{ __('Overtime\Approval.id') }}:</div>
                                    <div class="col-md-3"><input type="text" name="id_search" class="form-control" id="" value="{{ isset($id)?$id:'' }}"></div>
                                </div><br>
                                <div class="row">
                                    <div class="col-md-1">{{ __('Overtime\Approval.to') }}:</div>
                                    <div class="col-md-3">
                                        <input class="form-control" name="to_date" id="datepicker2" readonly style="background-color: white" type="text" onchange="check()"/>
                                    </div>
                                    <div class="col-md-1"></div>
                                    <div class="col-md-2">{{ __('Overtime\Approval.name') }}:</div>
                                    <div class="col-md-3"><input type="text" name="name_search" class="form-control" id="" value="{{ isset($name)?$name:'' }}"></div>
                                    <div class="col-md-2" style="text-align: center;" id="btn_search"><button class="btn btn-info">{{ __('Overtime\Approval.search_btn') }}</button></div>
                                </div>
                            </form>
                            <p></p> <br>
                            <table class="table table-hover table-bordered"  style="text-align: center">
                                <thead>
                                <tr>
                                    <th  style="text-align: center">{{ __('Overtime\Approval.date') }}</th>
                                    <th  style="text-align: center">{{ __('Overtime\Approval.name') }}</th>
                                    <th  style="text-align: center">{{ __('Overtime\Approval.duration') }}</th>
                                    <th  style="text-align: center">{{ __('Overtime\Approval.reason') }}</th>
                                    <th colspan="2"  style="text-align: center">{{ __('Overtime\Approval.action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @for($i=0;$i<count($overtime);$i++)
                                    <tr>
                                        <td>
                                            {{ $overtime[$i]['date'] }}
                                        </td>
                                        <td>
                                            {{ $overtime[$i]['user_name'] }}
                                        </td>
                                        <td>
                                            {{ $overtime[$i]['total'] }}
                                        </td>
                                        <td>
                                            {{ $overtime[$i]['reason'] }}
                                        </td>
                                        <td>
                                            <form action="{{ url('/doApproveOvertime/approve/'.$overtime[$i]['overtime_id']) }}">
                                                <button class="btn btn-info">{{ __('Overtime\Approval.btn_approve') }}</button>
                                            </form>
                                        </td>
                                        <td>
                                            <form action="{{ url('/doApproveOvertime/reject/'.$overtime[$i]['overtime_id']) }}">
                                                <button class="btn btn-info">{{ __('Overtime\Approval.btn_reject') }}</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

