<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Overtime extends Model
{
    //
    protected $table = 'overtime';
    protected $fillable = ['overtime_id','user_id','date','duration','reason','status'];
    protected $primaryKey='overtime_id';
    public $timestamps = false;

    public function store(Request $request)
    {
        $date = $request->input('date_daily');
        $user_id = Session::get('user_id');
        $hour = $request->get('hour_apply');
        $min = $request->get('min_apply');
        $duration = ($hour +$min/60);
        $reason = $request->get('reason_apply');
        $date_format = Carbon::parse($date)->format('Y-m-d');
        $overtime = new overtime();
        $overtime->user_id = $user_id;
        $overtime->date = $date_format;
        $overtime->duration = $duration;
        $overtime->reason = $reason;
        $overtime->status = 'pending';
        $overtime->save();
    }
}
