<?php

namespace App\Http\Controllers\AttendanceRecord;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;

class AttendanceRecordController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    //show list Attendance records
    public function showAttendanceList()
    {
        $user_id = Session::get('user_id');
        $date_format = Carbon::now()->format('Y-m-d');
        $daily_attendance_record = DB::select(DB::raw('SELECT daily_attendance.date,
                                daily_attendance.checkin,daily_attendance.checkout,
                                daily_attendance.break_time_hour,daily_attendance.total_working_hour,duration
                                FROM daily_attendance JOIN user ON daily_attendance.user_id = user.user_id 
                                LEFT JOIN overtime ON daily_attendance.overtime_id = overtime.overtime_id
                                WHERE daily_attendance.user_id = :user_id AND daily_attendance.date <= :date 
                                ORDER BY date DESC'), ['user_id'=>$user_id,'date'=>$date_format]);
        // Daily 1 time checkin and  checkout
        $Disable_checkin = '';
        $Disable_checkout = '';
        $Disable = DB::select(
            DB::raw('SELECT * FROM daily_attendance WHERE date = :date and user_id = :user_id'),
            ['date'=>$date_format,'user_id'=>$user_id]
        );
        // if condition use for    Daily 1 time checkin and  checkout
        if ($Disable != null) {
            if ($Disable[0]->checkin != ($date_format . ' 00:00:00')) {
                $Disable_checkin = 'Not active';
            }
            if ($Disable[0]->checkout != ($date_format . ' 00:00:00')) {
                $Disable_checkout = 'Not active';
            }
        }

        return view('attendance/attendance-record')
            ->with('daily_attendance_record', $daily_attendance_record)
            ->with('Disable_checkin', $Disable_checkin)
            ->with('Disable_checkout', $Disable_checkout);
    }
    //save data after checkin
    public function checkinInsert()
    {
        $user_id = Session::get('user_id');
        //Time zone set Asia/Ho chi Minh
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date_format = Carbon::now()->format('Y-m-d');
        $daily_attendance_id = 'daily_attendance_' . $date_format;
        $checkin = Carbon::now();
        $break_time_hour = 1;
        $checkout = $date_format . ' 00:00';
        $total_working_hour = 0;
        $old_record = DB::select(DB::raw('SELECT * FROM daily_attendance WHERE date = :date'), ['date'=>$date_format]);
        if ($old_record != null) {
            $checkout = $old_record[0]->checkout;
            $min = Carbon::parse($checkin)->diffInMinutes($checkout);
            $total_working_hour = round(($min/60), 2);
            DB::update(
                DB::raw('UPDATE daily_attendance SET checkin = :checkin,
                                total_working_hour = :total_working_hour,
                                status = :status 
                                WHERE 
                                daily_attendance_id = :daily_attendance_id'),
                [
                                'checkin'=>$checkin,
                                'daily_attendance_id'=>$old_record[0]->daily_attendance_id,
                                'total_working_hour'=>$total_working_hour,
                                'status'=>'approve'
                                ]
            );
            return redirect('attendance/record')->withErrors(__('AttendanceRecord/AttendanceRecord.checkin_success'));
        }
        $overtime_record = DB::select(
            DB::raw('SELECT * FROM overtime WHERE date = :date and user_id = :user_id'),
            ['date'=>$date_format,'user_id'=>$user_id]
        );

        if ($overtime_record!=null) {
            $overtime_id = $overtime_record[0]->overtime_id;
        } else {
            $overtime_id = 0;
        }
        $status = 'pending';
        DB::insert(
            DB::raw('INSERT INTO daily_attendance SET 
                         daily_attendance_id = :daily_attendance_id,
                         user_id = :user_id, date = :date, 
                         checkin = :checkin, 
                         checkout = :checkout, 
                         break_time_hour = :break_time_hour,
                         total_working_hour = :total_working_hour,
                         status = :status,
                         overtime_id = :overtime_id'),
            [
                        'daily_attendance_id'=>$daily_attendance_id,
                        'user_id'=>$user_id,
                        'date'=>$date_format,
                        'checkin'=>$checkin,
                        'checkout'=>$checkout,
                        'break_time_hour'=>$break_time_hour,
                        'total_working_hour'=>$total_working_hour,
                        'status'=>$status,
                        'overtime_id'=>$overtime_id
                         ]
        );
        return redirect('attendance/record')->withErrors(__('AttendanceRecord/AttendanceRecord.checkin_success'));
    }

    //save data after checkout
    public function checkoutUpdate(Request $request)
    {
        $user_id = Session::get('user_id');
        $date = $request->input('date');
        $date_format = Carbon::parse($date)->format('Y-m-d');
        $break_time_hour = 1;
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $old_record = DB::select(
            DB::raw('SELECT * FROM daily_attendance WHERE date = :date AND user_id = :user_id'),
            ['date'=>$date_format,'user_id'=>$user_id]
        );
        $checkin = $old_record[0]->checkin;
        $checkout = Carbon::now();
//        $hour = Carbon::parse($checkin)->diffInHours($checkout);
        $min = Carbon::parse($checkin)->diffInMinutes($checkout);
        $total_working_hour = round(($min / 60), 2);
        $status = 'approve';

        DB::update(
            DB::raw('UPDATE daily_attendance SET 
            checkout = :checkout, 
            checkin = :checkin,
            break_time_hour = :break_time_hour,
            total_working_hour = :total_working_hour, 
            status = :status 
            WHERE 
            user_id = :user_id 
            AND 
            date = :date'),
            [
             'checkout' => $checkout,
             'checkin' => $checkin,
             'break_time_hour' => $break_time_hour,
             'total_working_hour' => $total_working_hour,
             'status' => $status,
             'user_id'=>$user_id,
             'date'=>$date_format
            ]
        );
        return redirect('attendance/record')->withErrors(__('AttendanceRecord/AttendanceRecord.checkout_success'));
    }
}
