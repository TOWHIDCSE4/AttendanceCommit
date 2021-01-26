<?php

namespace App\Http\Controllers\Holiday;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;

class HolidayApplicationController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    //show holiday application form
    public function holidayApp()
    {
        $holiday = DB::select(DB::raw('SELECT * FROM holiday_type'));
        return view('Holiday.holiday-application')->with('holiday_type', $holiday);
    }
    // Add Holiday Application
    public function addHolidayApply(Request $request)
    {
        $user_id = Session::get('user_id');
        $holiday_id = $request->input('holiday_name');
        $apply_date = Carbon::now()->format('Y-m-d');
        $start = $request->input('start_date');
        $start_date = Carbon::parse($start)->format('Y-m-d');
        $end = Carbon::parse($request->input('end_date'));
        $end_date = Carbon::parse($end)->format('Y-m-d');
        $total_duration = $end->diffInDays($start_date)+1;
        $status = 'pending';
        $data_check = DB::select(
            DB::raw('SELECT * FROM user_holiday_information WHERE user_id = :user_id AND start_date <= :start_date AND end_date >= :end_date'),
            ['user_id'=>$user_id,'start_date'=>$start_date,'end_date'=>$start_date]
        );
        if (count($data_check)>0) {
            return redirect('holiday_application')->withErrors(__('Holiday\holidayApplication.M04'));
        }
        DB::insert(
            DB::raw('INSERT INTO user_holiday_information SET user_id = :user_id, holiday_id = :holiday_id,
 start_date = :start_date, end_date = :end_date, apply_date = :apply_date, total_duration = :total_duration, status = :status'),
            ['user_id'=>$user_id,'holiday_id'=>$holiday_id,'start_date'=>$start_date,'end_date'=>$end_date,'apply_date'=>$apply_date,
            'total_duration'=>$total_duration,
            'status'=>$status]
        );
        return redirect('holiday_application')->withErrors(__('Holiday\holidayApplication.M05'));
    }
}
