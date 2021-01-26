<!doctype html>
{{--@include('MasterPage')--}}
@extends('MasterPage')
@section('content')
<html lang="en">
<head>

    <!--resizing the screen name for small devices-->
    <style>
        #notificationListScreenName {
            font-size: 18px;
        }
        @media (min-width: 768px) {
            #notificationListScreenName {
                font-size: 32px;
            }
        }
    </style>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
{{--    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">--}}
    <!-- Bootstrap Date-Picker Plugin -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

    <title>{{__('notification\notificationList.notificationListBarTitle')}}</title>
</head>
<body>

<div class="container">
    <div class="col-md-12">
    <!--temporary logout button-->
{{--    <form id="logout-form" action="{{ route('logout') }}" method="POST" >--}}
{{--        @csrf--}}
{{--        <button type="submit" class="btn btn-info">Logout</button>--}}
{{--    </form>--}}
    <!-- The Modal -->
    <div class="modal fade" id="notificationDeleteModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Delete Notification</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    Are you sure, you want to delete?
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <!--form to delete notification-->
                    <form id="deleteFormModal" action="" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger">Ok</button>
                    </form>
                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
    <!--screen name-->
    <div class="row justify-content-center">
        <h1 id="notificationListScreenName">{{__('notification\notificationList.notificationListScreenTitle')}}</h1>
    </div>

    <!--search actions form-->
    <div class="row justify-content-center m-2 m-sm-3">
        <form>
            <!--first row for form input-->
            <div class="row form-group">

                <!--from date controls-->
                <div class="col-sm-2">
                    <label for="fromDateInput">{{__('notification\notificationList.fromDateLabel')}}</label>
                </div>
                <div class="col-sm-4">
                    <input class="form-control" id="fromDate" name="fromDate" autocomplete="off">
                </div>

                <!--to date controls-->
                <div class="col-sm-2">
                    <label for="fromDateInput">{{__('notification\notificationList.toDateLabel')}}</label>
                </div>
                <div class="col-sm-4">
                    <input class="form-control" id="toDate" name="toDate" autocomplete="off">
                </div>
            </div>

            <!--second row for form input-->
            <div class="row form-group">

                <!--status date controls-->
                <div class="col-sm-3">
                    <label for="statusInput">{{__('notification\notificationList.statusSelectBoxLabel')}}</label>
                </div>
                <div class="col-sm-5">
                    <select class="form-control" id="readStatusSelectBox" name="readStatusSelectBox">
                        <option value='all' class="form-group">{{__('notification\notificationList.statusOptionAll')}}</option>
                        <option value='read' class="form-group">{{__('notification\notificationList.statusOptionRead')}}</option>
                        <option value='unread' class="form-group">{{__('notification\notificationList.statusOptionUnread')}}</option>
                    </select>
                </div>

                <!--search button-->
                <div class="col-sm-4 text-center m-sm-0 m-2">
                    <button type="submit" id="searchNotificationButton" class="btn btn-info">{{__('notification\notificationList.searchButtonLabel')}}</button>
                </div>
            </div>
        </form>
    </div>
        <!--table body for showing notification list-->
        <div class="row">
            <table class="table table-bordered table-hover" id="notificationListTable">
                <thead>
                    <tr>
                        <th>{{__('notification\notificationList.notificationDateLabel')}}</th>
                        <th>{{__('notification\notificationList.senderNameLabel')}}</th>
                        <th>{{__('notification\notificationList.subjectLabel')}}</th>
                        <th>{{__('notification\notificationList.receiverLabel')}}</th>
                        <th>{{__('notification\notificationList.statusLabel')}}</th>
                        <th>{{__('notification\notificationList.operationLabel')}}</th>
                    </tr>
                </thead>
                <tbody id="notificationListTableBody">
                <!--showing the results got from notificationList stored procedure-->
                @foreach($notificationListData as $notificationList)
                    <tr>
                        <td>{{$notificationList->SentDate}}</td>
                        <td>{{$notificationList->Sender}}</td>
                        <td>{{$notificationList->Subject}}</td>
                        <!--for showing the break line -->
                        <td><?php echo $notificationList->Receiver ?></td>
                        <td>{{$notificationList->Status}}</td>
                        <td class="form-inline">@if ($notificationList->Status == 'draft')
                           <a class="btn btn-info m-sm-1 m-1" href="{{route('notification.edit', [$notificationList->NotificationID])}}">Edit</a>
                            @endif
                            @if ($notificationList->Status == 'send')
                            <a class="btn btn-info m-sm-1 m-1" href="{{route('notification.show', [$notificationList->NotificationID])}}">View</a>
                            @endif
                            <!--direct delete option
                            <form action = "{{route('notification.destroy', [$notificationList->NotificationID])}}" method = "post">
                                must add @
                                csrf
                                method('delete')
                                <button type="submit" class="btn btn-danger m-sm-1 m-1">Delete</button>
                            </form>
                            -->
                            <button class="btn btn-danger m-sm-1 m-1 NotificationDeleteButton" notificationId="{{$notificationList->NotificationID}}">Delete</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>

        <!--create new notification button-->
        <div class="row m-sm-3 m-3">
            <div class="col-sm-12 col-12">
                <a href="{{route('notification.create')}}" class="btn btn-danger">{{__('notification\notificationList.createNewNotificationButtonLabel')}}</a>
            </div>
        </div>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<!-- Bootstrap Date-Picker Plugin -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>

<!--date picker custom code-->
<script>
    $(document).ready(function(){
        //from date textbox
        var fromDateInput=$('input[name="fromDate"]');
        //from date textbox
        var toDateInput=$('input[name="toDate"]');
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        var options={
            format: 'yyyy/mm/dd',
            container: container,
            todayHighlight: true,
            autoclose: true,
        };
        fromDateInput.datepicker(options);
        toDateInput.datepicker(options);

        //search notification by ajax
        $("#searchNotificationButton").click( function (e) {
            e.preventDefault();
            //ajax request for search notification
            var fromDate = $("#fromDate").val();
            var toDate = $("#toDate").val();
            var readStatus = $("#readStatusSelectBox").val();
            $.ajax({
                type: 'post',
                url: '{{route('notification.search')}}',
                data: {_token: '{{csrf_token()}}', fromDate: fromDate, toDate: toDate, readStatus: readStatus},
                success: function (data) {
                    // alert('hello');
                    //alert(data.notificationSearchData);
                    //console.log(data.notificationSearchData);
                    //getting the results from response
                    var notificationSearchResult = data.notificationSearchData;
                    var length = 0;
                    if (notificationSearchResult != null) {
                        length = notificationSearchResult.length;
                        //alert(length);
                    }
                    if (length > 0) {
                        //empty the table data
                        $("#notificationListTable tbody").empty();
                        //alert('hello');
                        var routeOfEdit = '{{route('notification.edit', 'notificationID')}}';
                        var routeOfShow = '{{route('notification.show', 'notificationID')}}';
                        {{--var routeOfDelete = '{{route('notification.destroy', 'notificationID')}}';--}}
                        for (var i = 0; i < length; i++) {
                            //passing the parameters to the routes
                            routeOfEdit = routeOfEdit.replace('notificationID', notificationSearchResult[i].NotificationID);
                            routeOfShow = routeOfShow.replace('notificationID', notificationSearchResult[i].NotificationID);
                            var deleteButtonAttribute = 'notificationId=' + notificationSearchResult[i].NotificationID;
                            var tableRowData = '<tr><td>' + notificationSearchResult[i].SentDate + '</td>' +
                                '<td>' + notificationSearchResult[i].Sender + '</td>' +
                                '<td>' + notificationSearchResult[i].Subject + '</td>' +
                                '<td>' + notificationSearchResult[i].Receiver + '</td>' +
                                '<td>' + notificationSearchResult[i].Status + '</td><td>';
                                    if (notificationSearchResult[i].Status == 'draft') {
                                        tableRowData = tableRowData + '<a class="btn btn-info m-sm-1 m-1" href="' + routeOfEdit + '">Edit</a>';
                                    }
                            if (notificationSearchResult[i].Status == 'send') {
                                tableRowData = tableRowData + '<a class="btn btn-info m-sm-1 m-1" href="' + routeOfShow + '">View</a>';
                            }
                            //adding the delete button
                            tableRowData = tableRowData + '<button class="btn btn-danger m-sm-1 m-1 NotificationDeleteButton"' + deleteButtonAttribute + '>Delete</button>' +'</td>';
                            tableRowData = tableRowData +'</tr>';
                            //appending to table body
                            $("#notificationListTable tbody").append(tableRowData);
                        }

                    }
                }
            });
        });
        //code for modal on clicking delete button
        $('body').on('click', '.NotificationDeleteButton', function (e) {
            e.preventDefault();
            //alert('hello');
            //getting the notification id from delete button
            var notificationId = $(this).attr('notificationId');
            //setting the url for the delete form in modal
            var formUrlModal = '{{route('notification.destroy', 'notificationID')}}';
            formUrlModal = formUrlModal.replace('notificationID', notificationId);
            //setting the url in the action of the form in modal
            $("#deleteFormModal").attr('action', formUrlModal);
            //showing the modal
            $("#notificationDeleteModal").modal('show');
        });
    });

</script>
</body>
</html>
@endsection