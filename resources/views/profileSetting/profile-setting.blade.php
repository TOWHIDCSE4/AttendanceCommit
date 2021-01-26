@extends('MasterPage')
@section('title')
    {{__('ProfileSetting\profileSetting.title')}}
@endsection
@section('content')
    <style type="text/css">
        .wrapper{
            margin-top: -50px;
        }
        .profile-pic {
            max-width: 200px;
            max-height: 200px;
            display: block;
        }
        @media screen and (max-width: 768px) {
            .circle {
                /*position: relative;*/
                /*margin: auto;*/
            }
        }

        .circle {
            border-radius: 1000px !important;
            overflow: hidden;
            width: 128px;
            height: 128px;
            border: 8px solid rgba(255, 255, 255, 0.7);
            background-color: #95999c;
        }
        img {
            max-width: 100%;
            height: auto;
        }
        .p-image {
            position: absolute;
            top: 100px;
            left: 70px;
            color: #666666;
            transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
        }
        .p-image:hover {
            transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
        }
        .upload-button {
            font-size: 1.2em;
        }

        .upload-button:hover {
            transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
            color: #999;
        }
    </style>
    <script type="text/javascript">
        window.console = window.console || function(t) {};
        if (document.location.search.match(/type=embed/gi)) {
            window.parent.postMessage("resize", "*");
        }
        $(document).ready(function () {
            var readURL = function (input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('.profile-pic').attr('src', e.target.result);
                    };
                    if (input.files[0].size >200000) {
                        alert("{{__('UserCreation\UserCreation.imageAlert')}}");
                        // $('#blah').attr('src', 'https://placehold.it/180');
                        input.value = "";
                    }else{
                        reader.onload = function (e) {
                            $('#blah').attr('src', e.target.result);
                        };
                        reader.readAsDataURL(input.files[0]);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            };
            $(".file-upload").on('change', function () {
                readURL(this);
            });

            $(".upload-button").on('click', function () {
                $(".file-upload").click();
            });
        });
        function check_submit(){
            var pass = document.getElementById('password').value;
            var conf_pass = document.getElementById('confirm_password').value;
            if(pass != conf_pass){
                document.getElementById('confirm_password').style.borderColor = "red";
                document.getElementById('err').innerHTML = "Password not match";
                return false;
            }
            else{
                document.getElementById('confirm_password').style.borderColor = "";
                document.getElementById('err').innerHTML = "";
            }
        }
    </script>

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

                                        </h1>
                                        <form id="contact-form" method="post" onsubmit="return check_submit()" action="{{ url('/update_profile') }}" role="form" enctype="multipart/form-data">
                                            @csrf
                                            <div class="messages"></div>
                                            <div class="controls">
                                                <div class="row justify-content-center">
                                                    <div class="col-md-4" style="text-align: center;">
                                                        <div class="form-group" style="text-align: center;">                              {{-- image upload Field --}}
                                                            <div class="circle">
                                                                <img class="profile-pic" id="blah" src="{{ isset($user)?'images/'.$user[0]->image_path:'https://placehold.it/180' }}">
                                                            </div>
                                                            <div class="p-image">
                                                                <i class="fa fa-camera upload-button" style="cursor: pointer"></i>
                                                                <input class="file-upload" type="file" name="image_path" accept="image" style="display:none;">
                                                            </div>
                                                            <div class="help-block with-errors"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <div class="col-md-3">
                                                                <label for="form_name">{{__('UserCreation\UserCreation.userId')}}</label>           {{-- User ID Text Field --}}
                                                            </div>
                                                            <div class="col-md-9">
                                                                <input id="user_id" type="text" name="user_id" class="form-control" readonly style="background-color: white;"
                                                                       placeholder="{{__('UserCreation\UserCreation.userNamePlaceholder')}}" required="required" data-error="UserID is required."
                                                                       value="{{ \Illuminate\Support\Facades\Session::get('user_id') }}">     {{-- update_user function use for update userID only read not write --}}
                                                                <div class="help-block with-errors"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <div class="col-md-3">
                                                                <label for="form_lastname">{{__('UserCreation\UserCreation.userName')}}</label>          {{-- User Name Text Field --}}
                                                            </div>
                                                            <div class="col-md-9">
                                                                <input id="user_name" type="text" name="user_name" class="form-control" placeholder="{{__('UserCreation\UserCreation.userIdPlaceholder')}}" required="required" data-error="UserName is required."
                                                                       value="{{ isset($user)?$user[0]->user_name:'' }}">
                                                                <div class="help-block with-errors"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <div class="col-md-3">
                                                                <label for="form_name">{{__('ProfileSetting\profileSetting.email')}}</label>           {{-- Email Id Text Field --}}
                                                            </div>
                                                            <div class="col-md-9">
                                                                <input id="form_name" type="email" name="email" class="form-control"
                                                                       placeholder="{{__('UserCreation\UserCreation.emailIDPlaceholder')}}" required="required" data-error="UserID is required."
                                                                       value="{{ isset($user)?$user[0]->email:'' }}">
                                                                <div class="help-block with-errors"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <div class="col-md-3">
                                                                <label for="form_lastname">{{__('UserCreation\UserCreation.phone')}} </label>          {{-- Phone Number Text Field --}}
                                                            </div>
                                                            <div class="col-md-9">
                                                                <input id="phone" type="text" name="phone" class="form-control" placeholder="{{__('UserCreation\UserCreation.phoneplaceholder')}}" required="required" data-error="UserName is required."
                                                                       value="{{ isset($user)?$user[0]->phone:'' }}">
                                                                <div class="help-block with-errors"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <div class="col-md-3">
                                                                <label for="form_lastname">{{__('ProfileSetting\profileSetting.password')}}</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <input id="password" type="password" name="password" class="form-control" placeholder="Please enter your password" data-error="UserName is required."
                                                                       value="">
                                                                <div class="help-block with-errors"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <div class="col-md-3">
                                                                <label for="form_lastname">{{__('ProfileSetting\profileSetting.confPassword')}}</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <input id="confirm_password" onchange="check_submit()" type="password" name="" class="form-control" placeholder="Please re-enter your password" data-error="UserName is required."
                                                                       value="">
                                                                <div class="help-block with-errors">
                                                                    <p id="err"></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row justify-content-center">
                                                    <div class="col-md-3"></div>
                                                    <div class="col-md-9">
                                                        <div class="col-md-4" style="text-align: center">
                                                            {{--   User Creation Button --}}
                                                            <button type="submit" class="btn btn-success btn-send">
                                                                {{__('UserCreation\UserCreation.UpdateButton')}}
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
        </body>
@endsection
