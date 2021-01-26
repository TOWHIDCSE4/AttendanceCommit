<?php

use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\Department::create([
            'department_name'=>'BO',
            'description'=>'BackOffice'
        ]);
        \App\Department::create([
            'department_name'=>'HR',
            'description'=>'Human Resources'
        ]);
        \App\Department::create([
            'department_name'=>'Dev',
            'description'=>'Developer'
        ]);
        \App\Department::create([
            'department_name'=>'Test',
            'description'=>'Tester system'
        ]);
    }
}
