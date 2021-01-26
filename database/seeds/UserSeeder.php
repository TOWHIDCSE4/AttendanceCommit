<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\User::create([
            'user_id'=>'admin1',
            'user_name'=>'Bi',
            'email'=>'phanvanbinh2771997@gmail.com',
            'phone'=>'0123546789',
            'address' => 'Hanoi',
            'password'=>Hash::make('123456'),
            'image_path'=>'',
            'authority_id'=>'1',
            'position_id'=>'1',
            'department_id'=>'1',
            'manager_id'=>'0',
            'retirement'=>'N',
            'status'=>'N'
        ]);
        \App\User::create([
            'user_id'=>'manager1',
            'user_name'=>'Bin',
            'email'=>'phanbinh29081997@gmail.com',
            'phone'=>'023451259',
            'address' => 'HoChiMinh',
            'password'=>Hash::make('123456'),
            'image_path'=>'',
            'authority_id'=>'2',
            'position_id'=>'2',
            'department_id'=>'3',
            'manager_id'=>'1',
            'retirement'=>'N',
            'status'=>'N'
        ]);
        \App\User::create([
            'user_id'=>'employee1',
            'user_name'=>'Binh',
            'email'=>'emp@mail.com',
            'phone'=>'023451259',
            'address' => 'VietNam',
            'password'=>Hash::make('123456'),
            'image_path'=>'',
            'authority_id'=>'3',
            'position_id'=>'3',
            'department_id'=>'3',
            'manager_id'=>'1',
            'retirement'=>'N',
            'status'=>'N'
        ]);
    }
}
