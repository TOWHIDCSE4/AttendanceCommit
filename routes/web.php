<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('auth.login');
//});

//route for home
Route::get('/', 'Auth\LoginController@showLoginForm');

//authentication routes
//overriding the password.request method for user_id parameter
//Route::get('password/reset/{user}', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
//making the user registration false
//Auth::routes(['register' => false]);

Route::get('password/reset/{user_id}', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');

//Route::get('reset/{user_id}','Auth\ResetPasswordController@resetPassword');

Route::post('reset_pass', 'Auth\ResetPasswordController@resetPassword');

Route::post('reset', 'Auth\ResetPasswordController@reset');

Auth::routes(['register' => false]);

Route::get('home', 'HomeController@index')->name('home');

//this is the notification branch
//route for ajax request in notification creation page
Route::get('notification/create/{position}', 'Notification\NotificationController@getReceiverListFromPosition')
    ->name('notification.receiver');

//route for notification search functionality
route::post('notification/search', 'Notification\NotificationController@searchNotification')
    ->name('notification.search');

//using resource for the notification route
Route::resource('notification', 'Notification\NotificationController');


/*-------Route User--------*/
//Route User List
Route::get('user/list','User\UserController@userList')->name('user.list');
//Route User User Creation
Route::get('UserCreation','User\UserController@userCreation')->name('user.creation');
//Route User User ADD
Route::post('creation','User\UserController@userAdd')->name('user.creation');
//Route User User Update
route::get('update_user/{user_id}','User\UserController@updateUser')->name('user.update');
//Route User User Update for Show User List
route::post('update_user' ,'User\UserController@doUpDate' )->name('user.doUpDate');
//Route User Delete
route::get('delete_user','User\UserController@deleteUser')->name('user.delete');
//Route User Search
Route::get('UserSearch','User\UserController@userSearch')->name('user.search');

/*------Route Department-------*/
//Route show department list
Route::get('department', 'Department\DepartmentController@showDepartmentList');
//Route show create department form
Route::get('department/creation', 'Department\DepartmentController@creationDepartment');
//Route save data after entered information to add new department
Route::post('creation_dep', 'Department\DepartmentController@doAddDepartment');
//Route show form update department
Route::get('update_dep/{department_id}', 'Department\DepartmentController@updateDepartment');
//Route save data after entered information to update department
Route::post('update_dep', 'Department\DepartmentController@doUpdateDepartment');
//Route show dialog to confirm delete department
Route::get('delete_dep', 'Department\DepartmentController@deleteDepartment');
//Route delete department after confirmed
Route::get('delete_dep_confirm', 'Department\DepartmentController@doDeleteDepartment');


/*------Route Attendance record------*/
//Route show attendance record
Route::get('attendance/record','AttendanceRecord\AttendanceRecordController@showAttendanceList')->name('attendance.record');
//Route checkin attendance
Route::get('CheckinInsert','AttendanceRecord\AttendanceRecordController@checkinInsert')->name('checkin.insert');
//Route checkout attendance
Route::get('CheckoutUpdate','AttendanceRecord\AttendanceRecordController@checkoutUpdate')->name('checkout.update');

//Route additional time request
Route::get('additional_time_request','AttendanceRecord\AdditionalTimeController@additionalRequest')->name('additional_time_request');
//Route save data after apply additional time
Route::post('SaveAdditional_timeRequest','AttendanceRecord\AdditionalTimeController@saveAdditionalTime')->name('saveAdditional_timeRequest');

//Route additional time approval
Route::get('additional_approval','AttendanceRecord\AdditionalTimeController@additionalApproval')->name('additional_approval');
//Route Approve all record
Route::post('additionalTime_ApprovalAll','AttendanceRecord\AdditionalTimeController@approveAll')->name('additionalTime_approvalAll');
//Route change status
Route::get('Additional_change/{status}/{daily_attendance_id}','AttendanceRecord\AdditionalTimeController@doApprove')->name('additional_change');
//Route Additional Time Approval Search
ROute::get('ApprovalSearch','AttendanceRecord\AdditionalTimeController@approvalSearch')->name('approval_search');


/*-------Route Overtime-------*/
//Route show overtime request form
Route::get('overtime', 'Overtime\OvertimeController@overtimeRequest');
//Route save data after apply overtime
Route::post('overtime_apply', 'Overtime\OvertimeController@addOvertime');
//Route show overtime list
Route::get('overtime_approval', 'Overtime\OvertimeController@showOvertimeList');
//Route change status
Route::get('doApproveOvertime/{status}/{overtime_id}', 'Overtime\OvertimeController@doApprove');
//Route overtime search
Route::get('overtime_search', 'Overtime\OvertimeController@overtimeSearch');


/*------Route Work time a month-------*/
//Route show list
Route::get('one_month_approve', 'WorkTimeAMonth\OneMonthWorkingTimeApproval@oneMonthApproval');
//Route show detail
Route::get('months/one/{user_id}/{start_date}/{end_date}/{attendance_id}', 'WorkTimeAMonth\OneMonthWorkingTimeApproval@oneMonthDetail');
//Route do approval
Route::get('doApproveWorkTime/{status}/{monthly_attendance_id}', 'WorkTimeAMonth\OneMonthWorkingTimeApproval@doApprove');
//Route search
Route::post('oneMonthApprovalSearch', 'WorkTimeAMonth\OneMonthWorkingTimeApproval@oneMonthSearch');


/*-------Route profile setting----------*/
//Route show form update profile
Route::get('profile_setting', 'ProfileSetting\ProfileSettingController@showUserDetail');
//Route update
Route::post('update_profile', 'ProfileSetting\ProfileSettingController@updateProfile');


/*------Route holiday-------*/
//Route show form to apply holiday
Route::get('holiday_application', 'Holiday\HolidayApplicationController@holidayApp');
//Route save data after apply holiday
Route::post('holiday_apply', 'Holiday\HolidayApplicationController@addHolidayApply');
//Route show list holiday apply
Route::get('holiday_approval', 'Holiday\HolidayApprovalController@showHolidayApply');
//Route do approve holiday apply
Route::get('doApproveHoliday/{status}/{id}', 'Holiday\HolidayApprovalController@doApprovalHoliday');
//Route search
Route::post('holidayApprovalSearch', 'Holiday\HolidayApprovalController@searchHoliday');
