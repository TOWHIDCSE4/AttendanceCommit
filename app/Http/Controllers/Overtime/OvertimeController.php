<?php

namespace App\Http\Controllers\Overtime;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OvertimeController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    //show overtime application form
    public function overtimeRequest()
    {
        return view('Overtime.overtime-application');
    }
    //add new apply overtime record
    public function addOvertime(Request $request)
    {
        $date = $request->input('date_request');
        $date_format = Carbon::parse($date)->format('Y-m-d');
        $date_apply = Carbon::now()->format('Y-m-d');
        $hour = $request->get('hour_apply');
        $min = $request->get('min_apply');
        $hour_checkout = $request->get('hour_checkout');
        $min_checkout = $request->get('min_checkout');
        $checkout = $date_format.' '.$hour_checkout.':'.$min_checkout;
        $reason = $request->input('reason_apply');
        $duration = round($hour + ($min/60), 2);  //round the value of duration
        $user_id = Session::get('user_id');
        $old_data = DB::select(
            DB::raw('SELECT * FROM daily_attendance WHERE user_id = :user_id AND date = :date'),
            ['user_id'=>$user_id,'date'=>$date_format]
        );
        if (count($old_data)>0) {
            //If the registration date already exists, the message will be displayed
            return redirect('overtime')->withErrors(__('Overtime\Application.M004'));
        } else {
            $daily_attendance_id = 'daily_attendance_'.$date_format;
            $checkin = $date_format.' 00:00';
            //insert data into overtime table
            DB::insert(
                DB::raw('INSERT INTO overtime SET date = :date,user_id = :user_id, duration = :duration, reason = :reason, status = :status'),
                ['date'=>$date_apply,'user_id'=>$user_id,'duration'=>$duration,'reason'=>$reason,'status'=>'pending']
            );
            $overtime = DB::select(
                DB::raw('SELECT * FROM overtime WHERE date = :date AND user_id = :user_id ORDER BY overtime_id DESC LIMIT 1'),
                ['date'=>$date_apply,'user_id'=>$user_id]
            );
            //insert data into daily_attendance table
            DB::insert(
                DB::raw('INSERT INTO daily_attendance SET daily_attendance_id = :daily_attendance_id, user_id = :user_id, date = :date,
checkin = :checkin, checkout = :checkout, break_time_hour = :break_time_hour, total_working_hour = :total_working_hour, overtime_id = :overtime_id, status = :status'),
                ['daily_attendance_id'=>$daily_attendance_id, 'user_id'=>$user_id, 'date'=>$date_format,
                'checkin'=>$checkin,
                'checkout'=>$checkout,
                'break_time_hour'=>'1',
                'total_working_hour'=>'0' ,
                'overtime_id'=>$overtime[0]->overtime_id,
                'status'=>'pending_overtime']
            );
            return redirect('overtime')->withErrors(__('Overtime\Application.M005'));
        }
    }
    //show overtime list
    public function showOvertimeList()
    {
        $array = array();
        //get user_id of the manager who is logged in
        $manager_id = Session::get('user_id');
        //select user_id of the user with manager_id is manager, who is logged in
        $user_id1 = DB::select(DB::raw('SELECT user_id FROM user WHERE manager_id = :manager_id'), ['manager_id'=>$manager_id]);
        //count the number of user_id
        $c1 = count($user_id1);
        for ($i1=0; $i1<$c1; $i1++) {
            //select data from monthly attendance table with each user_id
            $overtime_record = DB::select(
                DB::raw('SELECT * FROM overtime JOIN user ON overtime.user_id = user.user_id WHERE overtime.status = :status AND overtime.user_id = :user_id'),
                ['status'=>'pending','user_id'=>$user_id1[$i1]->user_id]
            );
            //count the number of data records
            $c2 = count($overtime_record);
            for ($i2 = 0; $i2 < $c2; $i2++) {
                $total = $overtime_record[$i2]->duration;
                $overtime_id = $overtime_record[$i2]->overtime_id;
                $user_id2 = $overtime_record[$i2]->user_id;
                $user_name = $overtime_record[$i2]->user_name;
                $date = $overtime_record[$i2]->date;
                $reason = $overtime_record[$i2]->reason;
                //Add elements to the array
                array_push($array, ['overtime_id'=>$overtime_id,'user_id'=> $user_id2,'date'=>$date,'total'=>$total,'user_name'=>$user_name,'reason'=>$reason]);
            }
        }
        //Arrange the records
        sort($array);
        return view('Overtime\overtime-approval')->with('overtime', $array);
    }
    //do approve or reject record
    public function doApprove($status, $overtime_id)
    {
        $daily_attendance = DB::select(DB::raw('SELECT * FROM daily_attendance WHERE overtime_id = :overtime_id'), ['overtime_id'=>$overtime_id]);
        $date = $daily_attendance[0]->date;
        $checkin = $date.' 00:00:00';
        $checkout = $date.' 00:00:00';
        if ($status == 'approve') {
            DB::update(DB::raw('UPDATE overtime SET status = :status WHERE overtime_id = :overtime_id'), ['status'=>$status,'overtime_id'=>$overtime_id]);
        } else {
            //change status record in overtime table
            DB::update(DB::raw('UPDATE overtime SET status = :status WHERE overtime_id = :overtime_id'), ['status'=>$status,'overtime_id'=>$overtime_id]);
            //set checkout in daily_attendance table to become default value (00:00)
            DB::update(
                DB::raw('UPDATE daily_attendance SET checkin = :checkin, checkout = :checkout, total_working_hour = :total_working_hour WHERE daily_attendance.overtime_id = :overtime_id'),
                ['checkin'=>$checkin,'checkout'=>$checkout,'overtime_id'=>$overtime_id, 'total_working_hour'=>'0']
            );
        }
        return redirect('overtime_approval');
    }
    //Search record
    public function overtimeSearch(Request $request)
    {
        $from_date = $request->input('from_date');
        $to_date = $request->input('to_date');
        $user_id = $request->input('id_search');
        $name = $request->input('name_search');
        if ($from_date == null && $to_date == null && $user_id == null && $name==null) {
            return redirect('overtime_approval');
        }
        $array = array();
        //get user_id of the manager who is logged in
        $manager_id = Session::get('user_id');
        //select user_id of the user with manager_id is manager, who is logged in
        $user_id1 = DB::select(DB::raw('SELECT user_id FROM user WHERE manager_id = :manager_id'), ['manager_id'=>$manager_id]);
        //count the number of user_id
        $c1 = count($user_id1);
        for ($i1=0; $i1<$c1; $i1++) {
            $query = "SELECT * FROM overtime JOIN user ON overtime.user_id = user.user_id WHERE overtime.status = 'pending' AND overtime.user_id = '".$user_id1[$i1]->user_id."'";
            if ($from_date!=null) {
                $query = $query." AND date >= '".$from_date."'";
            }
            if ($to_date!=null) {
                $query = $query." AND date <= '".$to_date."'";
            }
            if ($user_id!=null) {
                $query = $query." AND overtime.user_id LIKE '%".$user_id."%'";
            }
            if ($name!=null) {
                $query = $query." AND user_name LIKE '%".$name."%'";
            }
            $overtime_record = DB::select(DB::raw($query));
            $c2 = count($overtime_record);
            for ($i2 = 0; $i2 < $c2; $i2++) {
                $total = $overtime_record[$i2]->duration;
                $overtime_id = $overtime_record[$i2]->overtime_id;
                $user_id2 = $overtime_record[$i2]->user_id;
                $user_name = $overtime_record[$i2]->user_name;
                $date = $overtime_record[$i2]->date;
                $reason = $overtime_record[$i2]->reason;
                //Add elements to the array
                array_push($array, ['overtime_id'=>$overtime_id,'user_id'=> $user_id2,'date'=>$date,'total'=>$total,'user_name'=>$user_name,'reason'=>$reason]);
            }
        }
        //Arrange the records
        sort($array);
        return view('Overtime\overtime-approval')->with('overtime', $array);
    }
}
