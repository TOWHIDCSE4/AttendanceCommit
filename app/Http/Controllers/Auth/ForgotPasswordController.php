<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
//use http\Env\Request;
//using request
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    //function for showing the email input screen
    public function showLinkRequestForm($user_id)
    {
        return view('auth.passwords.email')->with('user_id', $user_id);
    }

    //Send an email containing the link to reset the password
    public function sendEmail($email_DB)
    {
        Mail::send(
            'layouts.link', // The content inside the email contained in the view layouts/forgot.blade.php
            [
                'user'=>$email_DB
            ],
            function ($message) use ($email_DB) {
                //send email
                $message->to($email_DB[0]->email);
                $message->subject($email_DB[0]->user_name, "Reset password.");
            }
        );
    }

    //function for sending reset link to the given email
    public function sendResetLinkEmail(Request $request)
    {
        $g_mail = $request->input('email_reset');
        $user_id = $request->input('user_id');
        //Create a random string as the id of this execution
        $token = str_random('16');
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $time = Carbon::now();
        $email_DB = DB::select(DB::raw('SELECT * FROM user WHERE user_id = :user_id AND email = :email'), ['user_id'=>$user_id,'email'=>$g_mail]);
        if (count($email_DB)<=0) {
//            if email of this user id not match
            return redirect()->back()->with(['error'=> __('messages.M011')]);
        } else {
//            Call sendEmail function to send an email
            $this->sendEmail($email_DB);
//            insert data after send an email
//            passwordReset::insert(['email'=>$g_mail,'token'=>$token,'create_at'=>$time]);
            DB::insert(DB::raw('INSERT INTO passwordReset SET email = :email, token = :token, create_at = :create_at'), ['email'=>$g_mail,'token'=>$token,'create_at'=>$time]);
            return redirect()->back()->with(['success'=> __('messages.M010')]);
        }
    }
}
