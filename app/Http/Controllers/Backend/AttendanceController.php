<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Attendance;
use App\Models\Backend\Calendar;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function register_attendance(User $user,)
    {
        Attendance::create([
            'user_id' => $user->id,
            'day' => toBikramSambatDate(now()),
            'session_start' => \Carbon\Carbon::now()->format('H:i:s'),
            'login_location' => request()->ip()
        ]);
        return back();
    }

    public function terminate_session(User $user,)
    {
        $today = now()->toDateString();
        $user = Attendance::where('user_id', $user->id)
            ->whereDate('created_at', $today)
            ->whereNotNull('session_end')->first();

        return view('admin.backend.pages.tasks.crud', [
            'alreadySubmitted' => $user ? 'true' : false
        ]);
    }

    public function save_tasks(Request $request, User $user)
    {
        $requestData = $request->tasks;

        $today = now()->toDateString();

        $user = Attendance::where('user_id', $user->id)
            ->whereDate('created_at', $today)
            ->whereNull('session_end')->first();


        $currentDateTime = now();
        $previousDateTime = $user->created_at;

        $timeDifference = strtotime($currentDateTime) - strtotime($previousDateTime);

        $hours = floor($timeDifference / (60 * 60));
        $minutes = floor(($timeDifference % (60 * 60)) / 60);
        $seconds = $timeDifference % 60;

        $time_duration = $hours . ':' . $minutes . ':' . $seconds;


        $user->update([
            'session_end' => \Carbon\Carbon::now()->format('H:i:s'),
            'duration' => $time_duration,
            'logout_location' => request()->ip(),
            'task_report' => $requestData,
            'report_status' => 'pending'
        ]);

        // Return the response
        return response()->json([
            'result' => 'successful'
        ]);
    }

    public function view_reports()
    {
        $yesterday = Carbon::yesterday();
        $today = Carbon::today();
        $month = Calendar::whereDate('first_day', '<=', $today)->whereDate('last_day', '>=', $today)->first();


        $firstDay = Carbon::parse($month->first_day); // Assuming you retrieve the first_day from your model
        $lastDay = $today; //Carbon::parse($month->last_day);

        $publicHolidays = explode(',', $month->public_holidays); // Convert the CSV string to an array
        $publicHolidays = array_map('trim', $publicHolidays); // Trim spaces from each element

        $workingDays = $firstDay->diffInDaysFiltered(function (Carbon $date) use ($publicHolidays) {
            // Check if the current date is not a public holiday
            return !in_array($date->toDateString(), $publicHolidays);
        }, $lastDay);
        $workingDays = $workingDays + 1;


        $full_time_reports =    Attendance::join('users', 'attendances.user_id', '=', 'users.id')
            ->where('users.employment_type', 'full-time')
            ->where('attendances.report_status', 'pending')
            ->whereDate('attendances.created_at', $yesterday)
            ->select('attendances.*')
            ->get();

        $part_time_reports = Attendance::join('users', 'attendances.user_id', '=', 'users.id')
            ->where('users.employment_type', 'part-time')
            ->where('attendances.report_status', 'pending')
            ->whereDate('attendances.created_at', $yesterday)
            ->select('attendances.*')
            ->get();

        $unsubmitted = Attendance::whereDate('created_at', $yesterday)
            ->WhereNull('report_status')
            ->get();

        $attendanceData = User::join('attendances', 'users.id', '=', 'attendances.user_id')
            ->whereBetween('attendances.created_at', [$month->first_day, Carbon::today()])
            ->select('users.id', 'users.name', DB::raw('COUNT(attendances.id) as total_attendance_days'))
            ->groupBy('users.id', 'users.name')
            ->get();





        return view('admin.backend.pages.attendance.view_reports', [
            "full_time_reports" => $full_time_reports,

            "part_time_reports" => $part_time_reports,

            "unsubmitted" => $unsubmitted,

            "attendance_data" => $attendanceData,

            "working_days" => $workingDays
        ]);
    }

    public function take_action(Attendance $attendance, $action)
    {
        $attendance->update([
            'report_status' => $action
        ]);
        return back();
    }

    public function view($date = null)
    {
        $query = Attendance::where('user_id', Auth::user()->id);
        if (isset($date)) {
            $today = Carbon::today();
            $cal = Calendar::whereDate('first_day', '<=', $today)->whereDate('last_day', '>=', $today)->first();
            if ($date == "this-month") {
                $first_date = $cal->first_day;
                $second_date = $cal->last_day;
            } else if ($date == "last-month") {
                $second_date = (Carbon::parse($cal->first_day))->subDays(1);
                $cal2 = Calendar::whereDate('first_day', '<=', $second_date)->whereDate('last_day', '>=', $second_date)->first();
                $first_date = $cal2->first_day;
            }

            $reports = $query->whereDate('created_at', '>=', $first_date)->whereDate('created_at', '<=', $second_date)->orderBy('created_at', 'desc');
        } else {
            $reports = $query->orderBy('created_at', 'desc')->take(30);
        }

        return view('admin.backend.pages.attendance.view_report', [
            'user_attendance' => $reports->get(),
            "tasks" =>  $query->orderBy('created_at', 'desc')->select(DB::raw('SUM(JSON_LENGTH(task_report)) as total'))->first()
        ]);
    }

    public function generate_report(Request $request, User $user)
    {
        $results = Attendance::where('user_id', $user->id)
            ->whereDate('created_at', '>=', $request->start_date)
            ->whereDate('created_at', '<=', $request->end_date)
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json([
            'data' => $results
        ]);
    }

    public function today()
    {
        $today = now()->toDateString();
        $attendances = Attendance::whereDate('created_at', $today)->with('user')->orderBy('created_at', 'desc')->get();

        $usersWithoutAttendance = User::whereNotIn('id', $attendances->pluck('user_id'))->get();

        return view('admin.backend.pages.attendance.today', [
            'presents' => $attendances,
            'absents' => $usersWithoutAttendance
        ]);
    }

    public function individual_report(User $user, $date = null)
    {
        $query = Attendance::where('user_id', $user->id);
        if (isset($date)) {
            $today = Carbon::today();
            $cal = Calendar::whereDate('first_day', '<=', $today)->whereDate('last_day', '>=', $today)->first();
            if ($date == "this-month") {
                $first_date = $cal->first_day;
                $second_date = $cal->last_day;
            } else if ($date == "last-month") {
                $second_date = (Carbon::parse($cal->first_day))->subDays(1);
                $cal2 = Calendar::whereDate('first_day', '<=', $second_date)->whereDate('last_day', '>=', $second_date)->first();
                $first_date = $cal2->first_day;
            }
            $reports = $query->whereDate('created_at', '>=', $first_date)->whereDate('created_at', '<=', $second_date)->orderBy('created_at', 'desc');
        } else {
            $reports = $query->orderBy('created_at', 'desc');
        }
        return view('admin.backend.pages.attendance.individual_report', [
            "reports" => $reports->get(),
            "user" => $user,
            "tasks" =>  $reports
                ->select(DB::raw('SUM(JSON_LENGTH(task_report)) as total'))->first()

        ]);
    }
    public function individual_report_json(Request $request, User $user)
    {
        $query = Attendance::where('user_id', $user->id)->whereDate('created_at', '>=', $request->first_date)->whereDate('created_at', '<=', $request->second_date);

        return response()->json([
            'data' =>   $query->orderBy('created_at', 'desc')->get(),
            "tasks" =>  $query->orderBy('created_at', 'desc')->select(DB::raw('SUM(JSON_LENGTH(task_report)) as total'))->first()
        ]);
    }
}
