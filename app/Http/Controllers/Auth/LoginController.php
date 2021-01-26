<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }
    public function showLoginForm()
    {
        return view('auth.login');
    }

    //Processing after user entered information and submit
    public function login(Request $request)
    {
        $rules = [
            'user_id' =>'required',
            'password' => 'required|min:6'
        ];
        $messages = [
            'user_id.required' => 'ID là trường bắt buộc',
            'password.required' => 'Mật khẩu là trường bắt buộc',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $user_id = $request->input('user_id');
            $password = $request->input('password');


            if (Auth::attempt(['user_id' => $user_id, 'password' =>$password])) {
                $passDB = DB::select(DB::raw('SELECT* FROM user WHERE user_id = :user_id'), ['user_id'=>$user_id]);
                $user_status = $passDB[0]->status;
                $user_name = $passDB[0]->user_name;
                $authority = $passDB[0]->authority_id;
                $retirement = $passDB[0]->retirement;
                $image_path = $passDB[0]->image_path;
                Session::put('user_name', $user_name);
                Session::put('user_id', $user_id);
                Session::put('authority', $authority);
                Session::put('image_path', $image_path);

                if ($user_status=="N" && $retirement =="N") {
                    return redirect()->intended('home');
                } else {
                    $errors = new MessageBag(['errorlogin' => __('messages.M001')]);
                    return redirect()->back()->withInput()->withErrors($errors);
                }
            } else {
                $errors = new MessageBag(['errorlogin' => __('messages.M015')]);
                return redirect()->back()->withInput()->withErrors($errors);
            }
        }
    }

    //processing after user click logout button
    public function logOut(Request $request)
    {
        //Delete session()
        //$request->session()->flush();
        //using laravel function to log out
        Auth::logout();
        return redirect('login');
        //use auth::logout function
    }
}
