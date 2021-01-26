<!doctype html>
{{--@include('MasterPage')--}}
@extends('MasterPage')
@section('content')
<html lang="en">
<head>

    <!--resizing the screen name for small devices-->
    <style>
        #notificationDetailsScreenName {
            font-size: 18px;
        }
        @media (min-width: 768px) {
            #notificationDetailsScreenName {
                font-size: 32px;
            }
        }
    </style>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
{{--    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">--}}

    <title>{{__('notification\notificationDetails.notificationDetailsBarTitle')}}</title>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <h1 id="notificationDetailsScreenName">{{__('notification\notificationDetails.notificationDetailsScreenTitle')}}</h1>
    </div>

    <!--row for sender and sending date-->
    <div class="row justify-content-center m-sm-2">
        <label class="col-sm-1">{{__('notification\notificationDetails.senderLabel')}}</label>
        <div class="col-sm-3">
            <input class="form-control" value="{{$notificationData[0]->Sender}}" readonly>
        </div>
        <label class="col-sm-2">{{__('notification\notificationDetails.sendDateLabel')}}</label>
        <div class="col-sm-3">
            <input class="form-control" value="{{$notificationData[0]->SentDate}}" readonly>
        </div>
    </div>

    <!--row for notification subject-->
    <div class="row justify-content-center m-sm-2">
        <label class="col-sm-1">{{__('notification\notificationDetails.subjectLabel')}}</label>
        <div class="col-sm-11">
            <textarea class="form-control" rows="1" readonly>{{$notificationData[0]->Subject}}</textarea>
        </div>
    </div>

    <!--row for notification details-->
    <div class="row justify-content-center m-sm-2">
        <label class="col-sm-1">{{__('notification\notificationDetails.contentLabel')}}</label>
        <div class="col-sm-11">
            <textarea class="form-control" rows="5" readonly>{{$notificationData[0]->Content}}</textarea>
        </div>
    </div>
    <!--row for back button to notification list screen-->
    <div class="row justify-content-end m-sm-2">
        <div class="col-sm-6 text-sm-right text-center m-sm-1 m-2">
        <a href="{{route('notification.index')}}" class="btn btn-danger">{{__('notification\notificationDetails.backButtonLabel')}}</a>
    </div>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<!-- custom javascript code for showing the data  -->
</body>
</html>
@endsection