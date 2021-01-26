<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    public function resetPassword(Request $request)
    {
        $user_id = $request->input('user_id');
        return view('profileSetting.resetPassword')->with('user_id', $user_id);
    }
    public function reset(Request $request)
    {
        $new_pass = $request->input('password');
        $password = Hash::make($new_pass);
        $user_id = $request->input('user_id');
        DB::update(DB::raw('UPDATE user SET password = :password WHERE user_id = :user_id'), ['password'=>$password,'user_id'=>$user_id]);
        return redirect('/');
    }
}
