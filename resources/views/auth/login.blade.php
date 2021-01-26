<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ __('locale.titlePageLogin') }}</title>
    {{--        <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-3.3.1.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/alert.js') }}"></script>
</head>
<style>
    .wrapper{
        margin-top: 20px;
    }
    @media screen and (max-width: 1000px){
        /*Login Screen*/
        .wrapper{
            font-size: 42px;
            width: 100%;
        }
        .wrapper input{
            /*height: 200%;*/
            font-size: 42px;
        }
        .wrapper button{
            font-size: 36px;
        }
        /*End Login Screen*/
    }
</style>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-4">
                    <div class="card border-primary">
                        <div class="card-header bg-primary">{{ __('locale.titlePageLogin') }}</div>
                        <div class="card-body">
                            <form action="{{ route('login') }}" method="post" onsubmit="return check_error();">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-3">{{ __('locale.userIdLogin') }}</div>
                                    <div class="col-lg-8"><input type="text" class="form-control" id="user_id"  name="user_id" onchange="forgot_password()"
                                       onkeypress="return ((event.charCode >= 48 &&
                                        event.charCode <= 57) || (event.charCode >= 65 &&
                                        event.charCode <= 90) || (event.charCode >= 97 &&
                                        event.charCode <= 122) || (event.charCode <= 13) )" value="{{old('user_id')}}"></div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-lg-3">{{ __('locale.passwordLogin') }}</div>
                                        <div class="col-lg-8"><input type="password" class="form-control" id="password" name="password"></div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-lg-4"></div>
                                        <div class="col-lg-8" style="color: red; text-shadow: 1px 1px 1px red;" id="error">
                                            @if ($errors->any())
                                            @foreach ($errors->all() as $error)
                                            {{ $error }}
                                            @endforeach
                                            @endif
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-lg-4"></div>
                                        <div class="col-lg-8">
                                            <button class="btn btn-primary" type="submit">{{ __('locale.titlePageLogin') }}</button>
                                        </div>
                                    </div>
                                    <p></p>
                                    <div class="row">
                                        <div class="col-lg-4"></div>
                                        <div class="col-lg-8">
                                            <a href="{{ route('password.request') }}" id="forgot" style="color: #0069d9;" onclick="showMessages()">{{ __('locale.forgotLink') }}</a>
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
    <script !src="" type="text/javascript">
        $(function () {
            document.getElementById('user_id').focus();
            var user_id = document.getElementById('user_id').value;
            document.getElementById('forgot').setAttribute('href','password/reset/'+user_id);
            var error = document.getElementById('error').innerText;
            if(error == 'user not exists'){
                document.getElementById('user_id').focus();
            }
            if(error == 'Wrong password'){
                document.getElementById('password').focus();
            }

        });
        function forgot_password() {
            var user_id = document.getElementById('user_id').value;
            if(user_id.length>0){
                document.getElementById('forgot').setAttribute('href','password/reset/'+user_id);
            }else{
                document.getElementById('forgot').setAttribute('href','');
            }
        }
        function showMessages() {
            if(document.getElementById('user_id').value==""){
                alert("{{ __('messages.M012') }}");
                document.getElementById('forgot').removeAttribute('href');
                document.getElementById('user_id').focus();
            }
            if(document.getElementById('forgot').getAttribute('href')==""){
                alert("{{ __('messages.M012') }}");
                document.getElementById('forgot').removeAttribute('href');
            }
        }
        function check_error(){
            var user_id = document.getElementById('user_id').value;
            var pass_word = document.getElementById('password').value;
            if(user_id.length <= 0){
                alert("{{ __('messages.M012') }}");
                document.getElementById('user_id').focus();
                return false;
            }
            if(pass_word.length <= 0){
                alert("{{ __('messages.M013') }}");
                document.getElementById('password').focus();
                return false;
            }
            return true;
        }
    </script>
    </html>