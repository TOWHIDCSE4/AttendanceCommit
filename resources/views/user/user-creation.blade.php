@extends('MasterPage')
@section('title')
    @if($form_type=="creation") {{__('UserCreation\UserCreation.userCreation')}}  @elseif($form_type=="update_user") {{__('UserCreation\UserCreation.updatescreen')}}   @endif
@endsection
@section('content')
    <style>
        @media ( max-width: 800px){
            .card{
                bottom: 50px;
                width: 100%;
            }

        }
    </style>
    <body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    {{--                <div class="card border-info">--}}
                    <div class="" style="height: 850px;">
                        <div class="container">
                            <div class="row">
                                <div class="col-xl-8 offset-xl-2 py-5">
                                    <h1>
                                        @if($form_type=="creation") {{__('UserCreation\UserCreation.userCreation')}}  @elseif($form_type=="update_user") {{__('UserCreation\UserCreation.updatescreen')}}   @endif
                                    </h1>
                                    <form id="contact-form" method="post" action="{{ url('/'.$form_type) }}" role="form" enctype="multipart/form-data">
                                        @csrf
                                        <div class="messages"></div>
                                        <div class="controls">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">                              {{-- image upload Field --}}
                                                        <img id="blah" src="{{ isset($record[0]->image_path) ? asset('images/'.$record[0]->image_path): 'https://placehold.it/180' }}" alt="your image" style="
                width: 122px;
                height: 96px;
            "><br>              {{--Image Path --}}
                                                        <input type="file" id="file" name="image_path" multiple onchange="readURL(this);" style="
                 width: 201px;
                height: 29px;
            " value="{{ isset($record[0]->image_path) ? $record[0]->image_path: '' }}">

                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="form_name">{{__('UserCreation\UserCreation.userId')}}</label>           {{-- User ID Text Field --}}
                                                        <input id="form_name" type="text" name="user_id" class="form-control"
                                                               placeholder="{{__('UserCreation\UserCreation.userNamePlaceholder')}}" required="required" data-error="UserID is required."
                                                               value="{{ isset($record[0]->user_id)?$record[0]->user_id:'' }}" @if($form_type=='update_user') readonly @endif>     {{-- update_user function use for update userID only read not write --}}
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                                </div>


                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">{{__('UserCreation\UserCreation.userName')}}</label>          {{-- User Name Text Field --}}
                                                        <input id="" type="text" name="user_name" class="form-control" placeholder="{{__('UserCreation\UserCreation.userIdPlaceholder')}}" required="required" data-error="UserName is required."
                                                               value="{{isset($record[0]->user_name)?$record[0]->user_name:''}}">
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="form_name">{{__('UserCreation\UserCreation.emailId')}}</label>           {{-- Email Id Text Field --}}
                                                        <input id="form_name" type="email" name="email" class="form-control"
                                                               placeholder="{{__('UserCreation\UserCreation.emailIDPlaceholder')}}" required="required" data-error="UserID is required."
                                                               value="{{isset($record[0]->email)?$record[0]->email:''}}">
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                                </div>


                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">{{__('UserCreation\UserCreation.phone')}} </label>          {{-- Phone Number Text Field --}}
                                                        <input id="" type="text" name="phone" class="form-control" placeholder="{{__('UserCreation\UserCreation.phonePlaceholder')}}" required="required" data-error="UserName is required."
                                                               value="{{isset($record[0]->phone)?$record[0]->phone:''}}">
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="form_name">{{__('UserCreation\UserCreation.address')}}</label>           {{-- Address Text Field --}}
                                                        <textarea name="address" id="" cols="100" rows="3" class="form-control"placeholder="{{__('UserCreation\UserCreation.addressPlaceholder')}}" required="required"
                                                                  value="">{{isset($record[0]->address)?$record[0]->address:''}}</textarea>
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="form_need">{{__('UserCreation\UserCreation.authority')}}</label>          {{-- Authority combo box --}}
                                                        <select id="form_need" name="authority" class="form-control" required="required" data-error="Please specify your need.">
                                                            @foreach($authority as $row)
                                                                <option value="{{ $row->authority_id }}" @if(isset($record[0]->authority_id)) @if($row->authority_id==$record[0]->authority_id) selected @endif @endif>
                                                                    {{ $row->authority_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                                </div>



                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="form_need">{{__('UserCreation\UserCreation.position')}}</label>          {{-- Position combo box --}}
                                                        <select id="form_need" name="position" class="form-control" required="required" data-error="Please specify your need.">
                                                            @foreach($position as $row)
                                                                <option value="{{ $row->position_id }}" @if(isset($record[0]->position_id)) @if($row->position_id==$record[0]->position_id) selected @endif @endif>
                                                                    {{ $row->position_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="form_need">{{__('UserCreation\UserCreation.department')}}</label>               {{-- Department combo box --}}
                                                        <select id="form_need" name="department" class="form-control" required="required" data-error="Please specify your need.">
                                                            @foreach($department as $row)
                                                                <option value="{{ $row->department_id }}"@if(isset($record[0]->department_id)) @if($row->department_id==$record[0]->department_id) selected @endif @endif >
                                                                    {{ $row->department_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="form_need">{{__('UserCreation\UserCreation.manager')}}</label>                {{-- Manager combo box --}}
                                                        <select id="form_need" name="manager" class="form-control" required="required" data-error="Please specify your need.">
                                                            @foreach($manager as $row)
                                                                <option value="{{ $row->user_id }}"@if(isset($record[0]->user_id)) @if($row->user_id==$record[0]->user_id) selected @endif @endif >
                                                                    {{ $row->user_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-1" style="@if($form_type=="creation") display: none; @endif">
                                                    <div class="form-group">
                                                        <input type="checkbox" id="retirement" name="retirement" class="form-control" value="N" onclick="changeValue()">
                                                    </div>
                                                </div>
                                                <div class="col-md-2" style="padding: 10px 0px;">
                                                    <div class="form-group">
                                                        <label>{{__('UserCreation\UserCreation.retirement')}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        {{--   User Creation Button --}}
                                                        <button type="submit" class="btn btn-success btn-send">
                                                            @if($form_type=="creation") {{__('UserCreation\UserCreation.create')}} @elseif($form_type=="update_user") {{__('UserCreation\UserCreation.UpdateButton')}}  @endif
                                                        </button>

                                                        {{--  User Creation page Close Button  --}}
                                                        <button type="button" class="btn btn-success btn-send" onclick="window.history.go(-1); return false;">{{__('UserCreation\UserCreation.cancel')}}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--For Retirement data show in database but not show in User List--}}
    <script>
        function changeValue() {
            var retirement = document.getElementById('retirement');
            if(retirement.checked == true){
                var r = confirm("{{__('UserCreation\UserCreation.retirementAlert')}}");
                if(r == true){
                    document.getElementById('retirement').value='Y';
                }else{
                    $("#retirement").prop("checked", false);
                    document.getElementById('retirement').value='N';
                }
            }else
            {
                retirement.checked == false;
                document.getElementById('retirement').value='N';
            }
        }

        function readURL(input) {                                                            {{--  Image Size smaller 2MB For using javascript --}}
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            if (input.files[0].size >200000) {
                alert("{{__('UserCreation\UserCreation.imageAlert')}}");
                input.value = "";
            }else{
                reader.onload = function (e) {
                    $('#blah').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        }

    </script>
    </body>
@endsection