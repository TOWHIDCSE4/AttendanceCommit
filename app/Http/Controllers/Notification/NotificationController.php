<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotificationSearch;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

//this is the custom request for notification validation
use App\Http\Requests\NotificationRequest;
use phpDocumentor\Reflection\Types\Null_;

class NotificationController extends Controller
{
    //adding the auth middleware
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //getting user id from the auth
        $userID = $userID = Session::get('user_id');
        //$userID = '10001'; //get user id from the session
        //calling the stored procedure to get the notification list
        $notificationListData = DB::select('call getNotificationList(:userID)', ['userID' => $userID]);
        return view('notification\notification-list', compact('notificationListData'));
        //return $notificationList;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //declaring variable to detect the draft notification
        $isDraft = false;
        //getting position for select box
        $position = DB::select('select * from position');
        return view('notification\create-notification', compact('position', 'isDraft'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * using custom NotificationRequest for validation
     */
    public function store(NotificationRequest $request)
    {
        //getting user id from the auth
        $userID = Session::get('user_id');
        //declaring notification ID variable to pass storeReceiver function for both send and draft notification
        $notificationID = 0;
        //save the notification as 'sent notification'
        if ($request->input('submitButton') == 'send') {
            $this->storeNotificationData(
                $request->input('notificationSubject'),
                $request->input('notificationContent'),
                $userID, //authenticated user id
                Carbon::now()->toDateString(), //sending date, it will always be now
                Carbon::now()->toDateString(), //this is creation date, it must has creation date
                'send', //setting the status to send
                'unread' //setting the read status
            );
            //getting the auto incremented notification id from database
            $notificationID = $this->getNotificationIdByNotificationData(
                $request->input('notificationSubject'),
                $request->input('notificationContent'),
                $userID, //authenticated user id
                Carbon::now()->toDateString(), //creationDate, for send report it should be send date
                'send' //setting the status to draft
            );
        }

        //save the notification as drafts
        if ($request->input('submitButton') == 'draft') {
            $this->storeNotificationData(
                $request->input('notificationSubject'),
                $request->input('notificationContent'),
                $userID, //authenticated user id
                Carbon::now()->toDateString(), //for draft it is default today
                Carbon::now()->toDateString(), //carbon now today date
                'draft', //setting the status to draft
                'unread' //setting the read status
            );
            //getting the auto incremented notification id from database
            $notificationID = $this->getNotificationIdByNotificationData(
                $request->input('notificationSubject'),
                $request->input('notificationContent'),
                $userID, //authenticated user id
                Carbon::now()->toDateString(), //creationDate
                'draft' //setting the status to draft
            );
        }

        //inserting the receivers to the notification receiver table
        //getting the receiver list from view
        $receiver = $request->input('receiverSelectBox');
        if ($receiver == 0) { //all receiver is selected
            $receiverList = $this->getReceiverIdByPositionId($request->input('positionSelectBox'));
            //storing the receivers in the database
            $this->storeMultipleReceiverInNotificationReceiverTable($receiverList, $notificationID);
        } else { //receiver is an individual user
            //storing the receivers in the database
            $this->storeOneReceiverInNotificationReceiverTable($receiver, $notificationID);
        }
        //redirecting to notification list page
        return redirect()->route('notification.index');
    }

    /**
     * Display the notification details
     * @param  notification id
     * @return \Illuminate\Http\Response
     */
    public function show($notificationId)
    {
        //update the read history of the notifications
        DB::select('update notifications set read_status = :readStatus where notification_id = :notificationId', [
            'readStatus' => 'read',
            'notificationId' => $notificationId
        ]);
        //getting the notification data to show in view
        $notificationData = DB::select('call getNotificationDetails(:notificationID)', ['notificationID' => $notificationId]);
        return view('notification\notification-details', compact('notificationData'));
    }

    /**
     * This function is to edit the drafts notification
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($notificationId)
    {
        //passing a variable to know if it is draft notification
        $isDraft = true;
        //getting position for select box
        $position = DB::select('select * from position');
        //getting the notification data and passing to view
        $notificationData = $this->getNotificationDataByNotificationId($notificationId);
        return view('notification\create-notification', compact('notificationData', 'position', 'isDraft',
            'notificationId'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(NotificationRequest $request, $notificationId)
    {
        //if the send button is pressed
        if ($request->input('submitButton') == 'send') {
            $this->updateNotification(
                $notificationId,
                $request->input('notificationSubject'),
                $request->input('notificationContent'),
                Carbon::now()->toDateString(), //for sending notification only update the sending date
                'send' //setting the status to send
            );
        } else { //if the draft button is pressed
            $this->updateNotification(
                $notificationId,
                $request->input('notificationSubject'),
                $request->input('notificationContent'),
                Carbon::now()->toDateString(), //for draft notification only update the creation date
                'draft' //setting the status to draft
            );
        }
        //updating the receivers to the notification receiver table
        //getting the receiver list from view
        $receiver = $request->input('receiverSelectBox');
        if ($receiver == 0) { //all receiver is selected
            $receiverList = $this->getReceiverIdByPositionId($request->input('positionSelectBox'));
            //updating the receivers in the database
            $this->updateMultipleReceiverInNotificationReceiverTable($receiverList, $notificationId);
        } else { //receiver is an individual user
            //updating the receivers in the database
            $this->updateOneReceiverInNotificationReceiverTable($receiver, $notificationId);
        }
        //redirecting to notification list page
        return redirect()->route('notification.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($notificationId)
    {
        //first deleting notification receivers
        DB::select('delete from notification_receivers where notification_id = :notificationId', ['notificationId' => $notificationId]);
        //deleting from notifications table
        DB::select('delete from notifications where notification_id = :notificationId', ['notificationId' => $notificationId]);
        return redirect()->route('notification.index');
    }
    /**
     * This function is for getting receiver
     * by position id using ajax
     */
    public function getReceiverListFromPosition($positionIdToController)
    {
        //getting the user list by position id
        $receiver = DB::select(DB::raw('select * from user where position_id = :positionID'), ['positionID'=>$positionIdToController]);
        //return json array
        return response()->json(array('receiverData' => $receiver), 200);
    }
    /**
     * This function is to get user id
     * @param  position id
     * @return user id list
     */
    public function getReceiverIdByPositionId($positionId)
    {
        return (DB::Select('select user_id from user where position_id = :positionID', ['positionID' => $positionId]));
    }
    /**
     * This function is to save notification data in the database
     * @param  notification status
     * void function
     */
    public function storeNotificationData(
        $notificationSubject,
        $notificationContent,
        $sender,
        $sendingDate,
        $creationDate,
        $notificationStatus,
        $notificationReadStatus
    ) {
        //insert the notification data in the notification table
        DB::insert(
            'insert into notifications (subject, content, sender, sending_date, creation_date, status, read_status)
                               values (:subject, :content, :sender, :sending_date, :creation_date, :status, :read_status)',
            [
                'subject' => $notificationSubject,
                'content' => $notificationContent,
                'sender' => $sender,
                'sending_date' => $sendingDate,
                'creation_date' => $creationDate,
                'status' => $notificationStatus, //for draft it is always 'draft'
                'read_status' => $notificationReadStatus //notification read status
            ]
        );
    }
    /**
     * This function is to get the notification id from the database
     * @param  notification data
     * @return notification id
     */
    public function getNotificationIdByNotificationData(
        $notificationSubject,
        $notificationContent,
        $sender,
        $creationDate,
        $notificationStatus
    ) {
        $notificationId = (DB::select(
            'select notification_id from notifications where subject = :subject and content = :content 
                                                and sender = :sender and creation_date = :creation_date and status = :status limit 1',
            [
                'subject' => $notificationSubject,
                'content' => $notificationContent,
                'sender' => $sender,//authenticated user id
                'creation_date' => $creationDate,
                'status' => $notificationStatus
            ]
        ));
        //this for loops is for only accessing the stdObject of laravel
        //there will be only one notification id to return
        return $notificationId[0]->notification_id;
    }
    /**
     * This function is to insert receiver to the notification_receiver table
     * @param  notification_id and receiver list
     * void function
     */
    public function storeMultipleReceiverInNotificationReceiverTable($receiverList, $notificationId)
    {
        //storing the receivers in the database
        foreach ($receiverList as $perReceiver) {
            DB::insert(
                'insert into notification_receivers (receiver_id, notification_id) values
                               (:receiver, :notificationId)',
                [
                    'receiver' => $perReceiver->user_id,
                    'notificationId' => $notificationId
                ]
            );
        }
    }
    /**
     * This function is to insert only one receiver to the notification_receiver table
     * @param  notification_id and receiver
     * void function
     */
    public function storeOneReceiverInNotificationReceiverTable($receiver, $notificationId)
    {
        //storing the receivers in the database
        DB::insert(
            'insert into notification_receivers (receiver_id, notification_id) values
                               (:receiver, :notificationId)',
            [
                'receiver' => $receiver,
                'notificationId' => $notificationId
            ]
        );
    }
    /**
     * This function is to search notification according to search parameters
     * @param  post Request of notification searching
     * @return notification data in views
     */
    public function searchNotification(NotificationSearch $request)
    {
        if ($request->fromDate != null && $request->toDate != null && $request->readStatus != 'all') {
            $fromDate = $this->parseToDate($request->fromDate);
            $toDate = $this->parseToDate($request->toDate);
            $notificationData = DB::select('call searchNotification(:userId, :fromDate, :toDate, :readStatus)', [
                'userId' => '10004',
                'fromDate' => $fromDate,
                'toDate' => $toDate,
                'readStatus' => $request->readStatus
            ]);
            return response()->json(array('notificationSearchData' => $notificationData), 200);
        }
    }
    /**
     * This function is to get notification data
     * @param  notificationId
     * @return notificationData
     */
    public function getNotificationDataByNotificationId($notificationId)
    {
        //get notification data from database
        $notificationData = DB::select('call getNotificationDetails(:notificationID)', ['notificationID' => $notificationId]);
        //if receiver is more than 1 then Receiver is set to all
        if ($notificationData[0]->numberOfReceivers > 1) {
            $notificationData[0]->Receiver = 'All';
        }
        return $notificationData;
    }
    /**
     * This function is to update notification
     * @param  notificationData
     * update notification
     */
    public function updateNotification(
        $notificationId,
        $subject,
        $content,
        $sendingOrCreateDate,
        $status
    ) {
        if ($status == 'draft') {
            DB::select(
                'update notifications set subject = :subject, content = :content,
                           creation_date = :creationDate, status = :status where notification_id = :notificationId',
                ['subject' => $subject,
                    'content' => $content,
                    'creationDate' => $sendingOrCreateDate,
                    'status' => $status,
                    'notificationId' => $notificationId
                ]
            );
        } else { //when status == 'send'
            DB::select(
                'update notifications set subject = :subject, content = :content,
                           sending_date = :sendDate, status = :status where notification_id = :notificationId',
                ['subject' => $subject,
                    'content' => $content,
                    'sendDate' => $sendingOrCreateDate,
                    'status' => $status,
                    'notificationId' => $notificationId
                ]
            );
        }
    }
    /**
     * This function is to update multiple receiver
     * @param  receiver list notification id
     * update receiver list
     */
    public function updateMultipleReceiverInNotificationReceiverTable($receiverList, $notificationId)
    {
        //updating receiver list of the notification
        //deleting the receiver id from notification receiver's table
        DB::select('delete from notification_receivers where notification_id = :notificationId', ['notificationId' => $notificationId]);
        //inserting the receivers for updating
        foreach ($receiverList as $receivers) {
            DB::select('insert into notification_receivers (notification_id, receiver_id) values (:notificationId, :receiverId) ', [
                'notificationId' => $notificationId,
                'receiverId' => $receivers->user_id
            ]);
        }
    }
    /**
     * This function is to update one receiver
     * @param  receiver list notification id
     * update receiver
     */
    public function updateOneReceiverInNotificationReceiverTable($receiver, $notificationId)
    {
        //updating the single receiver id
        DB::select('update notification_receivers set receiver_id =:receiver where notification_id = :notificationId', [
            'receiver' => $receiver,
            'notificationId' => $notificationId
        ]);
    }
    /**
     * This function is to parse string in carbon date
     * @param  string date
     * @return carbon date
     */
    public function parseToDate($dateString)
    {
        if ($dateString == null) {
            return null;
        } else { //$dateString is not null
            return Carbon::parse($dateString)->toDateString();
        }
    }
}
