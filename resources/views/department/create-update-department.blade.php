@extends('MasterPage')
@section('title')
    @if($form_type=='creation_dep') {{ __('Department\departmentForm.title1') }} @else {{ __('Department\departmentForm.title2').' '.$record[0]->department_id.'('.$record[0]->department_name.')' }} @endif
@endsection
@section('content')
    <style type="text/css">
        @media ( max-width: 800px){
            /*Login*/
            .card{
                width: 100%;
            }
            #btn1{
                width: 50%;
                text-align: center;
            }
            #btn2{
                width: 50%;
                justify-content: center;
                text-align: center;
            }
        }
    </style>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card border-info">
                        <div class="card-header bg-info">
                            @if($form_type=='creation_dep') {{ __('Department\departmentForm.title1') }}
                            @else {{ __('Department\departmentForm.title2') }} @endif
                        </div>
                        <div class="card-body">
                            <form action="{{ url('/'.$form_type) }}" method="post" onsubmit="return check_error()">
                                @csrf
                                <div class="row" style="@if($form_type=='creation_dep') display: none; @endif">
                                    <div class="col-md-2">{{ __('Department\departmentForm.department_id') }}</div>
                                    <div class="col-md-4"><input type="text" class="form-control" name="department_id" @if($form_type=='update_dep') readonly @endif
                                        value="{{ isset($record[0]->department_id)?$record[0]->department_id:'' }}"></div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-2">{{ __('Department\departmentForm.department_name') }}</div>
                                    <div class="col-md-4"><input type="text" class="form-control" name="department_name" id="department_name"
                                                                 value="{{ isset($record[0]->department_name)?$record[0]->department_name:'' }}"></div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-2">{{ __('Department\departmentForm.description') }}</div>
                                    <div class="col-md-10"><input type="text" class="form-control" name="description" id="description"
                                                                  value="{{ isset($record[0]->description)?$record[0]->description:'' }}"></div>
                                </div>
                                <br>
                                <div class="row justify-content-center">
                                    <div class="col-md-2" id="btn1">
                                        <button class="btn btn-info" type="submit">
                                            @if($form_type=='creation_dep') {{ __('Department\departmentForm.btn_submit1') }} @else {{ __('Department\departmentForm.btn_submit2') }} @endif
                                        </button>
                                    </div>
                                    <div class="col-md-2" id="btn2">
                                        <button class="btn btn-info" onclick="window.history.go(-1); return false;">{{ __('Department\departmentForm.btn_cancel') }}</button>
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
            var department_name = document.getElementById('department_name').value;
            var description = document.getElementById('description').value;
            if(department_name.length <= 0){
                alert("{{ __('Department\departmentForm.messages1') }}");
                document.getElementById('department_name').focus();
                return false;
            }
            if(description.length <= 0){
                alert("{{ __('Department\departmentForm.messages2') }}");
                document.getElementById('description').focus();
                return false;
            }
        }
    </script>
@endsection