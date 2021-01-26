<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{__('locale.cardTitleForgot')}}</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-3.3.1.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
</head>
<style>
    .wrapper{
        margin-top: 20px;
    }
</style>
<body>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-4">
                <div class="card border-info">
                    <div class="card-header bg-info">{{ __('locale.cardTitleForgot') }}</div>
                    <div class="card-body">
                        <form action="{{ route('password.email') }}" method="post" onsubmit="return check_err()">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">{{ __('locale.titleForgot1') }}</div>
                                <div class="col-md-12">{{ __('locale.titleForgot2') }}</div>
                            </div><br>
                            <div class="row">
                                <div class="col-lg-6" style="color: red;">
                                    @if(session('error'))
                                        {{ session('error') }}
                                    @endif
                                    @if(session('success'))
                                        {{ session('success') }}
                                    @endif
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-lg-12"><input type="email" class="form-control" id="forgot" name="email_reset" ></div>
                                <input type="hidden" value="{{ $user_id }}" name="user_id">
                            </div><br>
                            <div class="row justify-content-center">

                                <div class="col-lg-2">
                                    <button class="btn btn-info" type="submit">{{ __('locale.getLinkButton') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function check_err() {
        var email = document.getElementById('forgot').value;
        if(email.length<=0){
            alert('{{ __('messages.M014') }}');
            return false;
        }
    }
</script>
</body>
</html>


