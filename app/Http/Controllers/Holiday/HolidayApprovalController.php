<?php

namespace App\Http\Controllers\Holiday;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class HolidayApprovalController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    //show holiday apply list
    public function showHolidayApply()
    {
        $data = DB::select(
            DB::raw('SELECT * FROM user_holiday_information 
JOIN user ON user_holiday_information.user_id = user.user_id 
JOIN holiday_type ON user_holiday_information.holiday_id = holiday_type.holiday_id WHERE user_holiday_information.status = :status'),
            ['status'=>'pending']
        );
        $holiday = DB::select(DB::raw('SELECT * FROM holiday_type'));
        return view('holiday.holiday-approval')->with('record', $data)->with('holiday', $holiday);
    }
    //do approve or reject a record
    public function doApprovalHoliday($status, $id)
    {
        DB::update(DB::raw('UPDATE user_holiday_information SET status = :status WHERE holiday_information_id = :id'), ['status'=>$status,'id'=>$id]);
        return redirect('holiday_approval');
    }
    //Search record
    public function searchHoliday(Request $request)
    {
        $from = $request->input('from_date');
        $to = $request->input('to_date');
        $name = $request->input('name_search');
        $holiday_type = $request->get('holiday_type');
        if ($from==null && $to==null && $name==null && $holiday_type==null) {
            return redirect('holiday_approval');
        }
        $query = "SELECT * FROM user_holiday_information JOIN user ON user_holiday_information.user_id = user.user_id 
JOIN holiday_type ON user_holiday_information.holiday_id = holiday_type.holiday_id WHERE user_holiday_information.status = 'pending'";
        if ($from!=null) {
            $query = $query." AND start_date >= '".$from."'";
        }
        if ($to!=null) {
            $query = $query." AND end_date <= '".$to."'";
        }
        if ($name!=null) {
            $query = $query." AND user_name LIKE '%".$name."%'";
        }
        if ($holiday_type!=null) {
            $query = $query."AND holiday_id = '".$holiday_type."'";
        }
        $data = DB::select(DB::raw($query));
        $holiday = DB::select(DB::raw('SELECT * FROM holiday_type'));
        return view('holiday.holiday-approval')->with('record', $data)->with('holiday', $holiday);
    }
}
