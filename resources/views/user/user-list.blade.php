{{--@include('MasterPage')--}}
@extends('MasterPage')
@section('title')
    {{__('UserList\UserList.userlist')}}
@endsection
@section('content')
<body>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-info">
                 <center> <div class="card-header bg-info">{{__('UserList\UserList.userlist')}}</div></center>


                    <div>
                        <div class="controls">
                            <form action="{{ url('/UserSearch') }}">
                            <div class="row justify-content-center">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="form_name">{{__('UserList\UserList.userId')}}</label>                        {{-- User ID Text Field --}}
                                        <input id="user_id" type="text" name="user_id" class="form-control" placeholder="{{__('UserList\UserList.userNamePlaceholder')}}"  data-error="UserID is required.">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>


                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="form_lastname">{{__('UserList\UserList.userName')}}</label>                         {{-- User Name Text Field --}}
                                        <input id="user_name" type="text" name="user_name" class="form-control" placeholder="{{__('UserList\UserList.userIdPlaceholder')}}" data-error="UserName is required.">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>


                            <div class="row justify-content-center">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="form_need">{{__('UserList\UserList.authority')}}</label>
                                        <select id="authority" class="form-control" name="authority">                                   {{-- Authority Name Text Field --}}
                                        @foreach($authority_record as $row)
                                                    <option value='{{ $row->authority_id }}'>{{ $row->authority_name }}</option>
                                                @endforeach
                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="form_need">{{__('UserList\UserList.position')}}</label>
                                        <select id="position" class="form-control" name="position">                                         {{-- Position Name Text Field --}}
                                            @foreach($position_record as $row)
                                                <option value='{{ $row->position_id }}'>{{ $row->position_name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>



                        <div class="row justify-content-center">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="form_need">{{__('UserList\UserList.department')}}</label>                                                                {{-- Department Name Text Field --}}
                                    <select id="department" name="department" class="form-control"  data-error="Please specify your need.">
                                        @foreach($department_record as $row)
                                            <option value='{{ $row->department_id }}'>{{ $row->department_name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>


                            <div class="row justify-content-center">
                                <div class="col-md-5"><button class="btn btn-info" type="Search">{{__('UserList\UserList.searchButton')}}</button></div>
                            </div>
                            </form>
                        </div>


                    <div class="card-body">
                        <table class="table table-hover table-bordered"  style="text-align: center">
                            <thead>
                            <tr>
                                <th style="text-align: center">{{ __('UserList\UserList.userId') }}</th>
                                <th style="text-align: center">{{ __('UserList\UserList.userName') }}</th>
                                <th style="text-align: center">{{ __('UserList\UserList.department') }}</th>
                                <th style="text-align: center">{{ __('UserList\UserList.position') }} </th>
                                <th style="text-align: center">{{ __('UserList\UserList.authority') }}</th>
                              <!--  <th style="text-align: center">Status</th>
                                <th style="text-align: center">説明</th>    --->
                                <th colspan="2" style="text-align: center">{{ __('UserList\UserList.action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($user_record as $row)

                                <tr>
                                    <td>{{ $row->user_id }}</td>
                                    <td>{{ $row->user_name }}</td>
                                    <td>{{ $row->department_name }}</td>
                                    <td>{{ $row->position_name }}</td>
                                    <td>{{ $row->authority_name }}</td>

                                    <td><form action="{{ url('/update_user/'.$row->user_id) }}"><button class="btn btn-info">{{__('UserList\UserList.UpdateButton')}}</button></form></td>
                                </tr>
                            @endforeach
                            </tbody>


                        </table>
                        <input type="hidden" id="hid" value="{{ isset($id)?$id:'' }}">
                        <div class="row">
                            <div class="col-md-1">
                                <form action="{{ url('/UserCreation') }}"><button class="btn btn-info" type="submit">{{ __('UserList\UserList.create') }}</button></form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
    $(function () {
        document.getElementById('user_id').value = "";
        document.getElementById('user_name').value = "";
        document.getElementById('department').value = "";
        document.getElementById('authority').value = "";
        document.getElementById('position').value = "";
    });
</script>
</body>
@endsection