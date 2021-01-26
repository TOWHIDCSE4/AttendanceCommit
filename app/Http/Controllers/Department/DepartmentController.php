<?php

namespace App\Http\Controllers\Department;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    // show department list
    public function showDepartmentList()
    {
        $dep_record =  DB::select(DB::raw('SELECT * FROM department'));
        return view('department.department-list')->with('dep_record', $dep_record);
    }
    // create new department
    public function creationDepartment()
    {
        $form_type = 'creation_dep';
        return view('department.create-update-department')->with('form_type', $form_type);
    }
    // Save data to the database after enter new department
    public function doAddDepartment(Request $request)
    {
        $name = $request->input('department_name');
        $description = $request->input('description');
        DB::insert(
            DB::raw('INSERT INTO department SET department_name = :department_name, description = :description'),
            ['department_name'=>$name,'description'=>$description]
        );
        return redirect('department');
    }
    // Update a department
    public function updateDepartment($request)
    {
        $id = $request;
        $form_type = 'update_dep';
        $dep_record = dB::select(DB::raw(
            'SELECT * FROM department WHERE department_id = :department_id'
        ), ['department_id'=>$id]);
        return view('department.create-update-department')->with('record', $dep_record)->with('form_type', $form_type);
    }
    // Save data to the database after change some information
    public function doUpdateDepartment(Request $request)
    {
        $id = $request->get('department_id');
        $dep_name = $request->get('department_name');
        $dep_description = $request->get('description');
        DB::update(
            DB::raw(
                'UPDATE department SET department_name = :department_name, 
                description = :description WHERE department_id = :department_id'
            ),
            [
                'department_name'=>$dep_name,
                'description'=>$dep_description,
                'department_id'=>$id
            ]
        );
        return redirect('department');
    }
    // Delete a department
    public function deleteDepartment(Request $request)
    {
        $id = $request->get('btn_del');
        $dep_record = DB::select(DB::raw('SELECT * FROM department'));
        return view('department.department-list')->with('id', $id)->with('dep_record', $dep_record);
    }
    // Perform processing to delete a department from database
    public function doDeleteDepartment(Request $request)
    {
        $id = $request->get('btn_yes');
        $no_id = $request->get('btn_no');
        if ($id != "") {
            DB::delete(DB::raw('DELETE FROM department WHERE department_id = :department_id'), ['department_id'=>$id]);
            DB::update(
                DB::raw('UPDATE user SET department_id = :department_id_1 WHERE department_id = :department_id_2'),
                ['department_id_1'=>'0','department_id_2'=>$id]
            );
        }
        if ($no_id != "") {
            return redirect('department');
        }
        return redirect('department');
    }
}
