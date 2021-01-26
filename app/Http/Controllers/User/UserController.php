<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Faker\Provider\Image;
use Illuminate\Support\Facades\DB;
use App\Authority;
use App\Department;
use App\Position;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //adding the auth middleware
    public function __construct()
    {
        $this->middleware('auth');
    }

// show user list
    public function userList()
    {
        $user_record = DB::select(DB::raw(
            'SELECT user_id, user_name, department_name, position_name, authority_name FROM user 

            LEFT JOIN department ON user.department_id = department.department_id 
            JOIN position ON user.position_id = position.position_id
            JOIN authority ON user.authority_id = authority.authority_id 
            WHERE retirement <> :retirement'
        ), ['retirement'=>'Y']);

        $authority_record =DB::select(DB::raw('SELECT * FROM authority'));
        $position_record = DB::select(DB::raw('SELECT * FROM position'));
        $department_record = DB::select(DB::raw('SELECT * FROM department'));
        $manager_record = DB::select(DB::raw('SELECT * FROM user WHERE position_id = 1'));


        return view('user/user-list')

        ->with('user_record', $user_record)
        ->with('authority_record', $authority_record)
        ->with('position_record', $position_record)
        ->with('department_record', $department_record)
        ->with('manager_record', $manager_record);
    }

///create new UserCreation
    public function userCreation()
    {
        $form_type = 'creation';
        $authority_record = DB::select(DB::raw("SELECT * FROM authority"));
        $position_record = DB::select(DB::raw('SELECT * FROM position'));
        $department_record = DB::select(DB::raw('SELECT * FROM department'));
//                Department::select('*')->get();
        $manager_record = DB::select(DB::raw('SELECT * FROM user WHERE position_id = 1'));
//                User::select('*')->where('position_id', '=', '1')->get();


        return view('user/user-creation')
        ->with('form_type', $form_type)
        ->with('authority', $authority_record)
        ->with('position', $position_record)
        ->with('department', $department_record)
        ->with('manager', $manager_record);
    }

    // Create User
    public function userAdd(Request $request)
    {
            // return "ok";
        $image_path = $request->input('image_path');
        $user_id = $request->input('user_id');
        $user_name = $request->input('user_name');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $address = $request->input('address');
        $password = Hash::make('123456');
        $authority = $request->get('authority');
        $position = $request->get('position');
        $department = $request->get('department');
        $manager = $request->get('manager');

        $image = $request->file('image_path');
        $name='';
        if ($image) {
            $name = $image->getClientOriginalName();
            $image->move('images', $name);
        }
        DB::insert(
            DB::raw('INSERT INTO user SET user_id = :user_id, 
                user_name = :user_name, image_path = :image_path,
                email = :email, phone = :phone, address = :address, 
                password = :password, authority_id = :authority_id,
                position_id = :position_id,
                department_id = :department_id, manager_id = :manager_id, 
                retirement = :retirement, status = :status'),
            [
                'user_id' => $user_id,
                'user_name' => $user_name,
                'image_path'=>$name,
                'email'=>$email,
                'phone'=>$phone,
                'address'=>$address,
                'password' => $password,
                'authority_id' => $authority,
                'position_id' => $position,
                'department_id' => $department,
                'manager_id' => $manager,
                'retirement' => 'N',
                'status' => 'active'
            ]
        );



        return redirect()->route('user.list');
    }

    // Update a User
    public function updateUser($request)
    {
        $user_id = $request;
        $form_type = 'update_user';
            //   $form_type ='creation';
        $authority_record = DB::select(DB::raw('SELECT * FROM authority'));
        $position_record = DB::select(DB::raw('SELECT * FROM position'));
        $department_record = DB::select(DB::raw('SELECT * FROM department'));
        $manager_record = DB::select(DB::raw('SELECT * FROM user WHERE position_id = :position'), ['position'=>'1']);
        $user_record = DB::select(DB::raw('SELECT * FROM user WHERE user_id = :user_id'), ['user_id'=>$user_id]);


        return view('user/user-creation')
        ->with('record', $user_record)
        ->with('form_type', $form_type)
        ->with('authority', $authority_record)
        ->with('position', $position_record)
        ->with('department', $department_record)
        ->with('manager', $manager_record);
    }

    // do update User
    public function doUpDate(Request $request)
    {
        $user_id=$request->input('user_id');
        $user_name=$request->input('user_name');
        $address=$request->input('address');
        $authority = $request->get('authority');
        $position = $request->get('position');
        $department = $request->get('department');
        $manager = $request->get('manager');
        $retirement=$request->get('retirement');
        if ($retirement!='Y') {
            $retirement = 'N';
        }
        $image = $request->file('image_path');
//            $name='';
        if ($image) {
            $name = $image->getClientOriginalName();
            $image->move('images', $name);
            DB::update(
                DB::raw('UPDATE user SET 
                    user_name = :user_name, 
                    address = :address, 
                    image_path = :image_path,
                    authority_id = :authority_id, 
                    position_id = :position_id, 
                    department_id = :department_id, 
                    manager_id = :manager_id,
                    retirement = :retirement,
                    status = :status WHERE user_id = :user_id'),
                [
                    'user_name' => $user_name,
                    'address' => $address,
                    'image_path' => $name,
                    'authority_id' => $authority,
                    'position_id' => $position,
                    'department_id' => $department,
                    'manager_id' => $manager,
                    'retirement' => $retirement,
                    'status' => 'active',
                    'user_id'=>$user_id
                ]
            );
        } else {
            DB::update(
                DB::raw('UPDATE user SET 
                    user_name = :user_name, 
                    address = :address, 
                    authority_id = :authority_id,
                    position_id = :position_id, 
                    department_id = :department_id,
                    manager_id = :manager_id, 
                    retirement = :retirement, 
                    status = :status WHERE user_id = :user_id'),
                [
                'user_name' => $user_name,
                'address' => $address,
                'authority_id' => $authority,
                'position_id' => $position,
                'department_id' => $department,
                'manager_id' => $manager,
                'retirement' => $retirement,
                'status' => 'active',
                'user_id'=>$user_id
                ]
            );
        }
        return redirect()->route('user.list');
    }

    //User Search
    public function userSearch(Request $request)
    {
        $user_id = $request->input('user_id');
        $user_name = $request->input('user_name');
        $authority = $request->get('authority');
        $position = $request->get('position');
        $department = $request->get('department');
//            $manager = $request->get('manager');
        $authority_record = DB::select(DB::raw('SELECT * FROM authority'));
        $position_record = DB::select(DB::raw('SELECT * FROM position'));
        $department_record = DB::select(DB::raw('SELECT * FROM department'));
        $manager_record = DB::select(DB::raw('SELECT * FROM user WHERE 
          position_id = :position_id'), ['position_id'=>'1']);

        $query="SELECT* from user JOIN department ON (user.department_id=department.department_id) 
        JOIN position on (user.position_id=position.position_id) 
        JOIN authority on (user.authority_id=authority.authority_id)  
        WHERE user.retirement!='Y'";
        if ($user_id!=null) {
            $query=$query. "and user.user_id LIKE '%" .$user_id."%'";
        }
        if ($user_name!=null) {
            $query=$query.  "and user.user_name LIKE '%" .$user_name."%'";
        }
        if ($authority!=null) {
            $query=$query.  " and authority.authority_id=".$authority."";
        }
        if ($position!=null) {
            $query=$query.  " and position.position_id=".$position."";
        }
        if ($department!=null) {
            $query= $query. " and department.department_id=".$department."";
        }
        $user_record= DB::select(DB::raw($query));

        return view('user/user-list')
        ->with('user_record', $user_record)
        ->with('authority_record', $authority_record)
        ->with('position_record', $position_record)
        ->with('department_record', $department_record)
        ->with('manager_record', $manager_record);
    }
}
