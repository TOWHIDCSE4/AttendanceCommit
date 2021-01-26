<?php

namespace App\Http\Controllers\WorkTimeAMonth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OneMonthWorkingTimeApproval extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    //return view one month working time approval
    public function oneMonthApproval()
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
            $one_month = DB::select(
                DB::raw('SELECT * FROM monthly_attendance JOIN user ON monthly_attendance.user_id = user.user_id WHERE monthly_attendance.status = :status AND monthly_attendance.user_id = :user_id'),
                ['status'=>'pending','user_id'=>$user_id1[$i1]->user_id]
            );
            //count the number of data records
            $c2 = count($one_month);
            for ($i2 = 0; $i2 < $c2; $i2++) {
                $total = 0;
                $one_month_id = $one_month[$i2]->monthly_attendance_id;
                $user_id2 = $one_month[$i2]->user_id;
                $user_name = $one_month[$i2]->user_name;
                $start_date = $one_month[$i2]->start_date;
                $end_date = $one_month[$i2]->end_date;
                //select data from daily attendance table with each record in monthly attendance table
                $one_month_detail = DB::select(
                    DB::raw('SELECT * FROM daily_attendance WHERE date >= :start_date AND date <= :end_date AND user_id = :user_id AND status = :status'),
                    ['start_date'=>$start_date,'end_date'=>$end_date,'user_id'=>$user_id2,'status'=>'approve']
                );
                //Count the number of records in daily attendance table
                $c3 = count($one_month_detail);
                for ($i3 = 0; $i3 < $c3; $i3++) {
                    //Calculate the total value of total working hour
                    $total = $total + $one_month_detail[$i3]->total_working_hour;
                }
                //Add elements to the array
                array_push($array, ['one_month_id'=>$one_month_id,'user_id'=> $user_id2,'start_date'=>$start_date,'end_date'=>$end_date, 'total'=>$total,'user_name'=>$user_name]);
            }
        }
        //Arrange the records
        sort($array);
        return view('WorkTimeAMonth\oneMonth-working-time-approval')
            ->with('one_month', $array);
    }
    // Search one month working time record
    public function oneMonthSearch(Request $request)
    {
        $array = array();
        $date = $request->input('date_search');
        $id = $request->input('id_search');
        $status = $request->input('status_search');
        $name = $request->input('name_search');

        //If all conditions are empty, return all records
        if ($date==null && $id==null && $name==null && $status==null) {
            return redirect('one_month_approve');
        }
        //get user_id of the manager who is logged in
        $manager_id = Session::get('user_id');
        //select user_id of the user with manager_id is manager, who is logged in
        $user_id1 = DB::select(DB::raw('SELECT user_id FROM user WHERE manager_id = :manager_id'), ['manager_id'=>$manager_id]);
        //count the number of user_id
        $c1 = count($user_id1);

        //If one of the conditions is filled, return the record with the corresponding query statement
        for ($i1=0; $i1<$c1; $i1++) {
            $query = "SELECT* from monthly_attendance JOIN user ON monthly_attendance.user_id = user.user_id WHERE monthly_attendance.status = 'pending' AND monthly_attendance.user_id = '".$user_id1[$i1]->user_id."'";
            //select data from monthly attendance table with each user_id
            if ($date!=null) {
                $query = $query." and MONTH(start_date) = '".$date."'"; //if date text field be filled
            }
            if ($id!=null) {
                $query = $query." and monthly_attendance.user_id LIKE '%".$id."%'"; //if ID text field be filled
            }
            if ($name!=null) {
//                $name_record = DB::select(DB::raw("SELECT user_id FROM user WHERE user_name LIKE :user_name"),['user_name'=>$name]);
//                for ($d=0; $d<count($name_record); $d++){
//                    $query = $query." and monthly_attendance.user_id ='".$name_record[$d]->user_id."'";
//                    $one_month = DB::select(DB::raw($query));
//                }
                $query = $query." and user_name LIKE '%".$name."%'"; //if name text field be filled
            }
            if ($status!=null) {
                $query = $query." and monthly_attendance.status = '".$status."'"; //if status text field be filled
            }
            $one_month = DB::select(DB::raw($query));
            //count the number of data records
            $c2 = count($one_month);
            for ($i2 = 0; $i2 < $c2; $i2++) {
                $total = 0;
                $one_month_id = $one_month[$i2]->monthly_attendance_id;
                $user_id2 = $one_month[$i2]->user_id;
                $user_name = $one_month[$i2]->user_name;
                $start_date = $one_month[$i2]->start_date;
                $end_date = $one_month[$i2]->end_date;
                //select data from daily attendance table with each record in monthly attendance table
                $one_month_detail = DB::select(
                    DB::raw('SELECT * FROM daily_attendance WHERE date >= :start_date AND date <= :end_date AND user_id = :user_id'),
                    ['start_date'=>$start_date,'end_date'=>$end_date,'user_id'=>$user_id2]
                );
                //Count the number of records in daily attendance table
                $c3 = count($one_month_detail);
                for ($i3 = 0; $i3 < $c3; $i3++) {
                    //Calculate the total value of total working hour
                    $total = $total + $one_month_detail[$i3]->total_working_hour;
                }
                //Add elements to the array
                array_push($array, ['one_month_id'=>$one_month_id,'user_id'=> $user_id2, 'start_date'=>$start_date,'end_date'=>$end_date, 'total'=>$total,'user_name'=>$user_name]);
            }
        }
        //Arrange the records
        sort($array);
        return view('WorkTimeAMonth\one-month-working-time-approval')
            ->with('one_month', $array)
            ->with('id', $id)->with('name', $name);
    }

    //show detail of working time in one month
    public function oneMonthDetail($user_id, $start_date, $end_date, $monthly_attendance_id)
    {
        $detail = DB::select(
            DB::raw('SELECT daily_attendance.date, checkin, daily_attendance.checkout, break_time_hour, duration, total_working_hour
 FROM daily_attendance LEFT JOIN overtime ON daily_attendance.overtime_id = overtime.overtime_id 
 WHERE daily_attendance.user_id = :user_id AND daily_attendance.date >= :start_date AND daily_attendance.date <= :end_date'),
            ['user_id'=>$user_id,'start_date'=>$start_date,'end_date'=>$end_date]
        );
        return view('WorkTimeAMonth\one-month-working-time-detail')
            ->with('detail_record', $detail)->with('monthly_attendance_id', $monthly_attendance_id);
    }

    //Approval One month working time
    public function doApprove($status, $monthly_attendance_id)
    {
        //change status record
//        monthlyAttendance::where('monthly_attendance_id','=',$monthly_attendance_id)->update(['status'=>$status]);
        DB::update(
            DB::raw('UPDATE monthly_attendance SET status = :status WHERE monthly_attendance_id = :monthly_id'),
            ['status'=>$status,'monthly_id'=>$monthly_attendance_id]
        );
        return redirect('one_month_approve');
    }
}
