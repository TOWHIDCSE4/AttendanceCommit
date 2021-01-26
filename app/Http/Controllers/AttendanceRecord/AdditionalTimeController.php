<?php

namespace App\Http\Controllers\AttendanceRecord;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;

class AdditionalTimeController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    //show additional time request form
    public function additionalRequest()
    {
        $form_type = 'additionalTime_request';
        return view('attendance.additional-time-request')->with('form_type', $form_type);
    }
    //save data to database after submit information
    public function saveAdditionalTime(Request $request)
    {
        $user_id = Session::get('user_id');
        $date = $request->input('date');
        $date_format = Carbon::parse($date)->format('Y-m-d');
        $daily_attendance_id = 'daily_attendance_' . $date;
        $break_time_hour = $request->input('break_time_hour');
        $break_time_min = $request->input('break_time_min');
        $break_time = $break_time_hour + $break_time_min / 60;
        $checkin_hour = $request->input('checkin_hour');
        $checkin_min = $request->input('checkin_min');
        $checkin = $date_format . ' ' . $checkin_hour . ':' . $checkin_min;
        $checkout_hour = $request->input('checkout_hour');
        $checkout_min = $request->input('checkout_min');
        $checkout = $date_format . ' ' . $checkout_hour . ':' . $checkout_min;
        $total_working_hour
        = round(($checkout_hour + $checkout_min / 60) - ($checkin_hour + $checkin_min / 60) - $break_time, 2) ;
        $overtime = DB::select(DB::raw('SELECT * from overtime WHERE date = :date'), ['date'=>$date_format]);

        if ($overtime == null) {
            $overtime_id = 0;
        } else {
            $overtime_id = $overtime[0]->overtime_id;
        }

        $status = 'pending_additional';
        $old_data = DB::select(DB::raw('select * from daily_attendance where date = :date'), ['date'=>$date_format]);

        // if condition use for Additional time date Checking 'This date Already exist'
        if (count($old_data)>0) {
            return redirect('additional_time_request')
            ->withErrors(__('AttendanceRecord/AttendanceRecord.additional_date'));
        } else {
            DB::insert(
                DB::raw('INSERT INTO daily_attendance SET 
                daily_attendance_id = :daily_attendance_id,
                user_id = :user_id, 
                total_working_hour = :total_working_hour, 
                checkin = :checkin, 
                checkout = :checkout, date = :date,
                break_time_hour = :break_time_hour, 
                overtime_id = :overtime_id, 
                status = :status'),
                [
                'daily_attendance_id' => $daily_attendance_id,
                'user_id' => $user_id,
                'total_working_hour' => $total_working_hour,
                'checkin' => $checkin,
                'checkout' => $checkout,
                'date' => $date_format,
                'break_time_hour' => $break_time,
                'overtime_id' => $overtime_id,
                'status' => $status]
            );
            return redirect('attendance_record');
        }
    }

    //show list additional time request
    public function additionalApproval()
    {
        $manager_id = Session::get('user_id');
        $user_id = DB::select(
            DB::raw('SELECT user_id FROM user WHERE manager_id = :manager_id'),
            ['manager_id'=>$manager_id]
        );

        $c = count($user_id);
        $array = array();
        for ($i=0; $i<$c; $i++) {
            $daily_attendance_record = DB::select(
                DB::raw('SELECT * FROM daily_attendance JOIN user ON daily_attendance.user_id = user.user_id 
                WHERE daily_attendance.status = :status AND daily_attendance.user_id = :user_id'),
                ['status'=>'pending_additional','user_id'=>$user_id[$i]->user_id]
            );
            for ($j=0; $j<count($daily_attendance_record); $j++) {
                array_push($array, ['daily_attendance_id'=>$daily_attendance_record[$j]->daily_attendance_id,
                    'user_id'=>$daily_attendance_record[$j]->user_id,
                    'user_name'=>$daily_attendance_record[$j]->user_name,
                    'date'=>$daily_attendance_record[$j]->date,
                    'checkin'=>$daily_attendance_record[$j]->checkin,
                    'checkout'=>$daily_attendance_record[$j]->checkout,
                    'break_time_hour'=>$daily_attendance_record[$j]->break_time_hour,
                    'total_working_hour'=>$daily_attendance_record[$j]->total_working_hour,
                    'overtime_id'=>$daily_attendance_record[$j]->overtime_id,
                    'status'=>$daily_attendance_record[$j]->status]);
            }
        }
        return view('attendance.additional-time-approval')->with('daily_attendance_record', $array);
    }

    //Approve all records
    public function approveAll()
    {
        $manager_id = Session::get('user_id');
        $user_id = DB::select(
            DB::raw('SELECT user_id FROM user 
                   WHERE manager_id = :manager_id'),
            ['manager_id'=>$manager_id]
        );
                   $c = count($user_id);
        for ($i=0; $i<$c; $i++) {
            DB::update(
                DB::raw('UPDATE daily_attendance SET 
                                status = :status1 
                                WHERE 
                                status = :status2 
                                AND 
                                user_id = :user_id'),
                [
                                'status1'=>'approve',
                                'status2'=>'pending',
                                'user_id'=>$user_id[$i]->user_id
                             ]
            );
        }
        return redirect('additional_approval');
    }

    //Approve or reject each records
    public function doApprove($status, $daily_attendance_id)
    {
        DB::update(
            DB::raw('UPDATE daily_attendance SET 
                status = :status 
                WHERE 
                daily_attendance_id = :daily_attendance_id'),
            [
                'status'=>$status,
                'daily_attendance_id'=>$daily_attendance_id
               ]
        );
        return redirect('additional_approval');
    }
    
    //Search record
    public function approvalSearch(Request $request)
    {
        $user_id = $request->input('user_id');
        $user_name = $request->input('user_name');
        $from_date=$request->input('FromDate');
        $to_date=$request->input('ToDate');
        if ($user_id==null && $user_name==null && $from_date==null && $to_date==null) {
            return redirect('additional_approval');
        }
        $manager_id = Session::get('user_id');
        $user_id_record = DB::select(DB::raw('SELECT user_id FROM user 
                          WHERE manager_id = :manager_id'), ['manager_id'=>$manager_id]);
        $c = count($user_id_record);
        $array = array();
        for ($i=0; $i<$c; $i++) {
            $query = "SELECT* from daily_attendance JOIN user ON user.user_id = daily_attendance.user_id 
            WHERE daily_attendance.status = 'pending' 
            AND daily_attendance.user_id = '" . $user_id_record[$i]->user_id . "'";

            if ($user_id != null) {
                $query = $query . "and user.user_id LIKE '%" . $user_id . "%'";
            }
            if ($user_name != null) {
                $query = $query . " and user.user_name LIKE '%" . $user_name . "%'";
            }
            if ($from_date != null) {
                $query = $query . " and date >= '" . $from_date . "'";
            }
            if ($to_date != null) {
                $query = $query . " and date <= '" . $to_date . "'";
            }
            if ($from_date != null && $to_date != null) {
                $query = $query . " and date BETWEEN '" . $from_date . "' AND '" . $to_date . "'";
            }

            $user_record = DB::select(DB::raw($query));

            for ($j = 0; $j < count($user_record); $j++) {
                array_push($array, ['daily_attendance_id' => $user_record[$j]->daily_attendance_id,
                    'user_id' => $user_record[$j]->user_id, 'user_name' => $user_record[$j]->user_name,
                    'date' => $user_record[$j]->date, 'checkin' => $user_record[$j]->checkin,
                    'checkout' => $user_record[$j]->checkout, 'break_time_hour' => $user_record[$j]->break_time_hour,
                    'total_working_hour' => $user_record[$j]->total_working_hour,]);
            }
        }
        return view('attendance.additional-time-approval')
            ->with('user_id', $user_id)
            ->with('user_name', $user_name)
            ->with('FromDate', $from_date)
            ->with('ToDate', $to_date)
            ->with('daily_attendance_record', $array);
    }
}
