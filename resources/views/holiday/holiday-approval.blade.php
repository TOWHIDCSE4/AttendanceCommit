@extends('MasterPage')
@section('title')
    {{__('Holiday\holidayApproval.title')}}
@endsection
@section('content')
    <script>
        $( function() {
            $( "#datepicker" ).datepicker({
                format: "yyyy-mm-dd",
                autoclose: true
            });
            $( "#datepicker1" ).datepicker({
                format: "yyyy-mm-dd",
                autoclose: true
            });
        } );
        function checkDate(){
            var from = document.getElementById('datepicker').value;
            var to = document.getElementById('datepicker1').value;
            if(from>to){
                alert('{{__('Holiday\holidayApproval.M01')}}');
                document.getElementById('datepicker1').value = "";
                return false;
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
                        <div class="card-header bg-info">{{__('Holiday\holidayApproval.title')}}</div>
                        <div class="card-body">
                            <form action="{{ url('/holidayApprovalSearch') }}" method="post" onsubmit="return checkDate()">
                                @csrf
                                <div class="row">
                                    <div class="col-md-1">{{__('Holiday\holidayApproval.from')}}:</div>
                                    <div class="col-md-3">
                                        <input class="form-control" name="from_date" id="datepicker" readonly style="background-color: white" type="text"/>
                                    </div>
                                    <div class="col-md-1"></div>
                                    <div class="col-md-2">{{__('Holiday\holidayApproval.name')}}:</div>
                                    <div class="col-md-3"><input type="text" name="name_search" class="form-control" id="" value=""></div>
                                </div><br>
                                <div class="row">
                                    <div class="col-md-1">{{__('Holiday\holidayApproval.to')}}:</div>
                                    <div class="col-md-3">
                                        <input class="form-control" name="to_date" id="datepicker1" readonly style="background-color: white" type="text"/>
                                    </div>
                                    <div class="col-md-1"></div>
                                    <div class="col-md-2">{{__('Holiday\holidayApproval.holidayType')}}:</div>
                                    <div class="col-md-3">
                                        <select name="holiday_type" id="" class="form-control">
                                            <option value=""></option>
                                            @foreach($holiday as $row)
                                                <option value="{{ $row->holiday_id }}">{{ $row->holiday_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2" style="text-align: center;" id="btn_search"><button class="btn btn-info">{{__('Holiday\holidayApproval.searchBtn')}}</button></div>
                                </div>
                            </form>
                            <p></p> <br>
                            <table class="table table-hover table-bordered"  style="text-align: center">
                                <thead>
                                <tr>
                                    <th  style="text-align: center">{{__('Holiday\holidayApproval.time')}}</th>
                                    <th  style="text-align: center">{{__('Holiday\holidayApproval.name')}}</th>
                                    <th  style="text-align: center">{{__('Holiday\holidayApproval.holidayType')}}</th>
                                    <th colspan="2"  style="text-align: center">{{__('Holiday\holidayApproval.action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($record as $row)
                                    <tr>
                                        <td>
                                            {{ $row->start_date.' ~ '.$row->end_date }}
                                        </td>
                                        <td>
                                            {{ $row->user_name }}
                                        </td>
                                        <td>
                                            {{ $row->holiday_name }}
                                        </td>
                                        <td>
                                            <form action="{{ url('/doApproveHoliday/approve/'.$row->holiday_information_id) }}">
                                                <button class="btn btn-info">{{ __('Holiday\holidayApproval.approveBtn') }}</button>
                                            </form>
                                        </td>
                                        <td>
                                            <form action="{{ url('/doApproveHoliday/reject/'.$row->holiday_information_id) }}">
                                                <button class="btn btn-info">{{ __('Holiday\holidayApproval.rejectBtn') }}</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

