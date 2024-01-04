<?php

use App\Http\Controllers\Backend\AttendanceController;
use App\Http\Controllers\Backend\CalendarController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\LeaveController;
use App\Http\Controllers\Backend\GroupController;
use App\Http\Controllers\Backend\TeamController;
use App\Http\Controllers\Backend\NoticeController;
use App\Http\Controllers\Backend\PermissionController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\UserController;
use Illuminate\Support\Facades\Route;

/*
        Admin Routes
    */

Route::get("/dashboard", [DashboardController::class, "index"])->name("dashboard");

Route::get('/unauthorized', function () {
    return view('unauthorized');
})->name('unauthorized');

/*
    ============================================================================
                User Routes
    ============================================================================
*/

Route::group(['prefix' => 'user', "as" => "user-", 'middleware' => ['roles']], function () {
    Route::get("/", [UserController::class, "index"])->name("view");
    Route::get("/create", [UserController::class, "create"])->name("create");
    Route::post("/store", [UserController::class, "store"])->name("store");
    Route::get("/edit/{user}", [UserController::class, "edit"])->name("edit");
    Route::post("/update/{user}", [UserController::class, "update"])->name("update");
    Route::get("/delete/{user}", [UserController::class, "destroy"])->name("delete");
    Route::get("/status-update/{user}", [UserController::class, "update_status"])->name("update_status");

    Route::get('/target/{user}', [UserController::class, "target"])->name('target');
    Route::post("/target/{user}", [UserController::class, "post_target"])->name('post_target');

    Route::get("/profile", [UserController::class, "update_profile"])->name("update_profile");
    Route::get('/profile/upload-photo', [UserController::class, "upload_photo"])->name('upload_photo');
    Route::post('/profile/upload-photo', [UserController::class, "post_upload_photo"])->name('post_upload_photo');

    Route::get('/update-password', [UserController::class, "update_password"])->name('update_password');
    Route::post('/update-password', [UserController::class, "post_update_password"])->name("post_update_password");

    Route::get('/user/permission/{user}', [UserController::class, "user_permission"])->name('user_permission');
});

/*
    ============================================================================
                Permission Routes
    ============================================================================
*/

Route::group(['prefix' => 'permission', "as" => "permission-", 'middleware' => ['roles']], function () {
    Route::get("/", [PermissionController::class, "index"])->name("view");
    Route::get("/create", [PermissionController::class, "create"])->name("create");
    Route::post("/store", [PermissionController::class, "store"])->name("store");
    Route::get("/edit/{permission}", [PermissionController::class, "edit"])->name("edit");
    Route::post("/update/{permission}", [PermissionController::class, "update"])->name("update");
    Route::get("/delete/{permission}", [PermissionController::class, "destroy"])->name("delete");
    Route::get("/status-update/{permission}", [PermissionController::class, "update_status"])->name("update_status");
});

/*
    ============================================================================
                Role Routes
    ============================================================================
*/

Route::group(['prefix' => 'role', "as" => "role-", 'middleware' => ['roles']], function () {
    Route::get("/", [RoleController::class, "index"])->name("view");
    Route::get("/create", [RoleController::class, "create"])->name("create");
    Route::post("/store", [RoleController::class, "store"])->name("store");
    Route::get("/edit/{role}", [RoleController::class, "edit"])->name("edit");
    Route::post("/update/{role}", [RoleController::class, "update"])->name("update");
    Route::get("/delete/{role}", [RoleController::class, "destroy"])->name("delete");
    Route::get("/status-update/{role}", [RoleController::class, "update_status"])->name("update_status");
});

/*
    ============================================================================
                Attendance Routes
    ============================================================================
*/
Route::group(['prefix' => 'attendance', 'as' => 'attendance-', 'middleware' => ['roles']], function () {
    Route::get('/register/{user}', [AttendanceController::class, 'register_attendance'])->name('register_attendance');
    Route::get('/submit-tasks/{user}', [AttendanceController::class, 'terminate_session'])->name('terminate_session');
    Route::post('/save-task/{user}', [AttendanceController::class, 'save_tasks'])->name('save_tasks');

    Route::get('/view-reports', [AttendanceController::class, 'view_reports'])->name('view_reports');
    Route::post('/report/{attendance}/{action}', [AttendanceController::class, 'take_action'])->name('take_action');

    Route::get('/view-report/{date?}', [AttendanceController::class, 'view'])->name('view');
    Route::post('/generate-report/{user}', [AttendanceController::class, 'generate_report'])->name('generate_report');

    Route::get('/today', [AttendanceController::class, 'today'])->name('today');

    Route::get('/individual-report/{user}/{date?}', [AttendanceController::class, 'individual_report'])->name('individual_report');
    Route::post('/individual-report/{user}/{date?}', [AttendanceController::class, 'individual_report_json'])->name('individual_report_json');
});

/*
    ============================================================================
                Calendar Routes
    ============================================================================
*/
Route::group(['prefix' => 'calendar', 'as' => 'calendar-', 'middleware' => ['roles']], function () {
    Route::get('/add-date', [CalendarController::class, 'create'])->name('create');
    Route::post('/add-date', [CalendarController::class, 'store'])->name('store');
    Route::get('/view', [CalendarController::class, 'index'])->name('index');
    Route::get('/edit/{date}', [CalendarController::class, 'edit'])->name('edit');
    Route::post('/update/{date}', [CalendarController::class, 'update'])->name('update');

    Route::get('/public-holidays', [CalendarController::class, 'public_holiday_index'])->name('public_holiday_index');
});

/*
    ============================================================================
                Leave Routes
    ============================================================================
*/
Route::group(['prefix' => 'leave', 'as' => 'leave-', 'middleware' => ['roles']], function () {
    Route::get('/apply', [LeaveController::class, 'create'])->name('create');
    Route::post('/apply/{user}', [LeaveController::class, 'store'])->name('store');
    Route::get('/approvals', [LeaveController::class, 'index'])->name('index');
    Route::post('/approve/{leave}', [LeaveController::class, 'approve'])->name('approve');
    Route::post('/reject/{leave}', [LeaveController::class, 'reject'])->name('reject');

    Route::get('/individual/{user}', [LeaveController::class, 'individual'])->name('individual');
});
/*
    ============================================================================
                Notice Routes
    ============================================================================
*/
Route::group(['prefix' => 'notice', 'as' => 'notice-', 'middleware' => ['roles']], function () {
    Route::get('/create', [NoticeController::class, 'create'])->name('create');
    Route::post('/store', [NoticeController::class, 'store'])->name('store');
    Route::get('/edit/{notice}', [NoticeController::class, 'edit'])->name('edit');
    Route::post('/update/{notice}', [NoticeController::class, 'update'])->name('update');

    Route::get('/view', [NoticeController::class, 'view'])->name('view');
    Route::get('/view/{notice}/{user}', [NoticeController::class, 'view_single'])->name('view_single');
    Route::get('/terminate/{notice}', [NoticeController::class, 'terminate_notice'])->name('terminate_notice');
});
/*
    ============================================================================
                Team Routes
    ============================================================================
*/
Route::group(['prefix' => 'team', 'as' => 'team-'], function () {
    Route::get('/create', [TeamController::class, 'create'])->name('create');
    Route::post('/store', [TeamController::class, 'store'])->name('store');
    Route::get('/edit/{team}', [TeamController::class, 'edit'])->name('edit');
    Route::post('/update/{team}', [TeamController::class, 'update'])->name('update');
});
/*
    ============================================================================
                Group Routes
    ============================================================================
*/
Route::group(['prefix' => 'group', 'as' => 'group-'], function () {
    Route::get('/create', [GroupController::class, 'create'])->name('create');
    Route::post('/store', [GroupController::class, 'store'])->name('store');
    Route::get('/edit/{group}', [GroupController::class, 'edit'])->name('edit');
    Route::post('/update/{group}', [GroupController::class, 'update'])->name('update');
});
