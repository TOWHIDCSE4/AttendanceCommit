<?php

namespace App\Http\Controllers\ProfileSetting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ProfileSettingController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function showUserDetail()
    {
        $user_id = Session::get('user_id');
        $user = DB::select(DB::raw('SELECT * FROM user WHERE user_id = :user_id'), ['user_id'=>$user_id]);
        return view('ProfileSetting.profile-setting')->with('user', $user);
    }
    public function updateProfile(Request $request)
    {
        $user_id = Session::get('user_id');
        $user_name = $request->input('user_name');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $password_input = $request->input('password');
        $image = $request->file('image_path');
        $name='';
        if ($image) {
//            $name = $image->getClientOriginalName();
            $name = $image->getFilename();
            $image->move('images', $name);
        }
        if ($name != null) {
            $img = DB::select(DB::raw('SELECT image_path FROM user WHERE user_id = :user_id'), ['user_id'=>$user_id]);
            if ($img[0]->image_path != null && file_exists('images/'.$img[0]->image_path)) {
                unlink('images/'.$img[0]->image_path);
            }
            if ($password_input != null) {
                $password = Hash::make($password_input);
                DB::update(
                    DB::raw('UPDATE user SET user_name = :user_name, email = :email, phone = :phone, image_path = :image_path, password = :password WHERE user_id = :user_id'),
                    ['user_name'=>$user_name,'email'=>$email,'phone'=>$phone,'image_path'=>$name,'password'=>$password,'user_id'=>$user_id]
                );
                return redirect('/');
            } else {
                DB::update(
                    DB::raw('UPDATE user SET user_name = :user_name, email = :email, phone = :phone, image_path = :image_path WHERE user_id = :user_id'),
                    ['user_name'=>$user_name,'email'=>$email,'phone'=>$phone,'image_path'=>$name,'user_id'=>$user_id]
                );
                return redirect('/');
            }
        } else {
            if ($password_input != null) {
                $password = Hash::make($password_input);
                DB::update(
                    DB::raw('UPDATE user SET user_name = :user_name, email = :email, phone = :phone, password = :password WHERE user_id = :user_id'),
                    ['user_name'=>$user_name,'email'=>$email,'phone'=>$phone,'password'=>$password,'user_id'=>$user_id]
                );
                return redirect('/');
            } else {
                DB::update(
                    DB::raw('UPDATE user SET user_name = :user_name, email = :email, phone = :phone WHERE user_id = :user_id'),
                    ['user_name'=>$user_name,'email'=>$email,'phone'=>$phone,'user_id'=>$user_id]
                );
                return redirect('/');
            }
        }
    }
}
