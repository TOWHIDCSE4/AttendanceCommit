<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{__('locale.titleResetPassword')}}</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-3.3.1.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-latest.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
    <script type="text/javascript">
        $('#reset_form').submit(function () {
            alert('Password was update');
        });
        function check_submit(){
            var pass = document.getElementById('password').value;
            var conf_pass = document.getElementById('conf_password').value;
            if(pass != conf_pass){
                document.getElementById('conf_password').style.borderColor = "red";
                document.getElementById('err').innerHTML = "Password not match";
                return false;
            }
            else{
                document.getElementById('conf_password').style.borderColor = "";
                document.getElementById('err').innerHTML = "";
                alert('Password was update');
            }
        }
        function showPass() {
            var pass = document.getElementById('conf_password').getAttribute('type');
            if(pass == 'password'){
                document.getElementById('conf_password').setAttribute('type','text');
                document.getElementById('eye').setAttribute('class','fa fa-fw fa-eye-slash');
            }else{
                document.getElementById('conf_password').setAttribute('type','password');
                document.getElementById('eye').setAttribute('class','fa fa-fw fa-eye');
            }
        }
    </script>
</head>
<style>
    .wrapper{
        margin-top: 20px;
    }
    #eye{
        position: absolute;
        right: 25px;
        top: -25px;
        opacity: 0.5;
        cursor: pointer;
    }
    #eye:hover{
        opacity: 1;
    }
</style>
<body>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-4">
                <div class="card border-info">
                    <div class="card-header bg-info">{{__('locale.titleResetPassword')}}</div>
                    <div class="card-body">
                        <form action="{{ url('/reset') }}" method="post" onsubmit="return check_submit()" id="reset_form">
                            @csrf
                            <div class="row">
                                <div class="col-lg-4">{{__('locale.newPassword')}}</div>
                                <div class="col-lg-8"><input type="password" class="form-control" id="password" name="password" ></div>
                            </div><br>
                            <div class="row">
                                <div class="col-lg-4">{{__('locale.confPassword')}}</div>
                                <div class="col-lg-8"><input type="password" class="form-control" id="conf_password" name="conf_password" onchange=""></div>
                                <div class="col-lg-12"> <span toggle="#password-field" id="eye" class="fa fa-fw fa-eye" onclick="showPass()"></span></div>
                                <div class="col-lg-12" id="err"></div>
                            </div><br>
                            <div class="row justify-content-center">
                                <div class="col-lg-4">
                                    <button class="btn btn-info" type="submit">{{__('locale.resetButton')}}</button>
                                    <input type="hidden" name="user_id" value="{{ $user_id }}">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>


