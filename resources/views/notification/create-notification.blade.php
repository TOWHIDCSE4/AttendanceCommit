<!doctype html>
{{--@include('MasterPage')--}}
@extends('MasterPage')
@section('content')
<html lang="en">
<head>

    <!--resizing the screen name for small devices-->
    <style>
        #notificationCreateUpdateScreenName {
            font-size: 18px;
        }
        @media (min-width: 768px) {
            #notificationCreateUpdateScreenName {
                font-size: 32px;
            }
        }
    </style>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
{{--    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">--}}

    <title>{{__('notification\notificationScreens.notificationCreationBarTitle')}}</title>
</head>
<body>

<div class="container">
    <!-- displaying error messages -->
    @if ($errors->any())
        <div class="alert alert-danger m-sm-3 justify-content-center">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row justify-content-center">
        <h1 id="notificationCreateUpdateScreenName">{{__('notification\notificationScreens.notificationCreationScreenTitle')}}</h1>
    </div>

        <form method="post" @if ($isDraft == true) action = "{{route('notification.update', $notificationId)}}" @else action="{{route('notification.store')}}" @endif>
            @csrf
            @if ($isDraft == true)
            @method('put')
            @endif
                <div class="form-group row">
                    <label for="inputPosition" class="col-sm-1 col-form-label">{{__('notification\notificationScreens.positionLabel')}}</label>
                    <div class="col-sm-11">
                        <!--position selection -->
                        <select class="form-control" id="positionSelectBox" name="positionSelectBox">
                            <option value="0">{{__('notification\notificationScreens.positionSelectHeader')}}</option>
                            <!--checking if it is draft -->
                            @if ($isDraft == true)
                                @foreach ($position as $positionTemporary)
                                    <!--condition for not duplicating options for position -->
                                    @if ($notificationData[0]->ReceiverPosition == $positionTemporary->position_name)
                                        <option value="{{$positionTemporary->position_id}}" selected>{{$positionTemporary->position_name}}</option>
                                    @else
                                        <option value="{{$positionTemporary->position_id}}">{{$positionTemporary->position_name}}</option>
                                    @endif
                                @endforeach
                            @else <!--when it is not draft notification -->
                                @foreach($position as $positionTemporary)
                                <option value="{{$positionTemporary->position_id}}">{{$positionTemporary->position_name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputReceiver" class="col-sm-1 col-form-label">{{__('notification\notificationScreens.receiverLabel')}}</label>
                    <div class="col-sm-11">
                        <!--receiver selection -->
                        <select class="form-control" id="receiverSelectBox" name="receiverSelectBox">
                            <option value="0">{{__('notification\notificationScreens.receiverSelectHeader')}}</option>
                            @if ($isDraft == true)
                                <option value="{{$notificationData[0]->ReceiverID}}" selected>{{$notificationData[0]->Receiver}}</option>
                            @endif
                        </select>
                    </div>
                </div>
                <!--subject of notification -->
                <div class="form-group row">
                    <label for="inputSubject" class="col-sm-1 col-form-label">{{__('notification\notificationScreens.subjectLabel')}}</label>
                    <div class="col-sm-11">
                        @if ($isDraft == true)
                        <textarea class="form-control" rows="1" name="notificationSubject">{{$notificationData[0]->Subject}}</textarea>
                        @else
                            <textarea class="form-control" rows="1" name="notificationSubject"></textarea>
                        @endif
                    </div>
                </div>
            <!--content of notification -->
            <div class="form-group row">
                <label for="inputContent" class="col-sm-1 col-form-label">{{__('notification\notificationScreens.contentLabel')}}</label>
                <div class="col-sm-11">
                    @if ($isDraft == true)
                        <textarea class="form-control" rows="5" name="notificationContent">{{$notificationData[0]->Subject}}</textarea>
                    @else
                        <textarea class="form-control" rows="5" name="notificationContent"></textarea>
                    @endif
                </div>
            </div>

            <!--buttons for notification actions-->
                <div class="form-group row justify-content-center">
                    <div class="col-3 text-center col-sm-5 text-sm-right m-sm-0">
                        <button type="submit" class="btn btn-primary" name="submitButton" value="send">{{__('notification\notificationScreens.sendButtonValue')}}</button>
                    </div>
                    <div class="col-3 text-center m-1 col-sm-1 text-sm-left m-sm-0">
                        <button type="submit" class="btn btn-secondary" name="submitButton" value="draft">{{__('notification\notificationScreens.draftButtonValue')}}</button>
                    </div>
                    <div class="col-3 text-center m-1 col-sm-6 text-sm-left m-sm-0">
                        <a href="{{route('notification.index')}}" class="btn btn-danger">{{__('notification\notificationScreens.cancelButtonValue')}}</a>
                    </div>
                </div>
        </form>
</div>

<!-- Optional JavaScript -->

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!-- sending ajax request to get receivers list by position -->
<script>
    $(document).ready(function () {

        //when position select box changes
        $('#positionSelectBox').change (function () {

            //getting the position id from the select box value
            var position_id = $(this).val();
            var url = '{{route('notification.receiver', 'position')}}';
            url = url.replace('position', position_id);

            //empty the receiver dropdown to get required values only
            $('#receiverSelectBox').find('option').not(':first').remove();

            //sending ajax request
            $.ajax({
                type: 'get',
                url: url,
                success: function (response) {
                    var receivers = response.receiverData;
                    var length = 0;
                    if (receivers != null) {
                        length = receivers.length;
                    }
                    if (length > 0) {

                        //read data and set to the option
                        for (var i=0; i<length; i++) {
                            //this is receiver id
                            var receiver_id = receivers[i].user_id;
                            //this is receiver name
                            var receiver_name = receivers[i].user_name;
                            //setting value to the receiverSelectBox
                            var option = '<option value="' + receiver_id + '">' + receiver_name + '</option>';
                            $('#receiverSelectBox').append(option);
                        }
                    }
                }
            });
        });

    });
</script>
</body>
</html>
@endsection