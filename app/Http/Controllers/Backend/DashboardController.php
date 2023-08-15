<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Attendance;
use App\Models\Backend\Calendar;
use App\Models\Backend\Leave;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role->slug;
        if ($role == 'admin' || $role == 'superadmin' || $role == 'supervisor') {

            $today = Carbon::today();
            $yesterday = Carbon::yesterday();
            $present_today = Attendance::whereDate('created_at', $today)
                ->get()->unique('user_id');
            $on_leave = Leave::where(function ($query) use ($today) {
                $query->whereDate('date', $today)
                    ->orWhere(function ($subQuery) use ($today) {
                        $subQuery->whereDate('first_day', '<=', $today)
                            ->whereDate('last_day', '>=', $today);
                    });
            })->where('status', 'approved')->get();
            $excluded_ids = $present_today->pluck('user_id')
                ->merge($on_leave->pluck('user_id'))
                ->unique();

            $absent_today = User::whereNotIn('id', $excluded_ids)
                ->get();



            return view('admin.backend.pages.dashboard.index', [
                "present_today" => $present_today,
                "on_leave" => $on_leave,
                "absent_today" => $absent_today
            ]);
        } else {
            $month = Calendar::whereDate('first_day', '<=', Carbon::today())->whereDate('last_day', '>=', Carbon::today())->first();
            $query = Attendance::where('user_id', Auth::user()->id)->whereBetween('created_at', [$month->first_day, $month->last_day]);

            $present_this_month = $query->count();

            $task_this_month = $query->get()
            ->reduce(function ($totalTasks, $attendance) {
                $tasks = json_decode($attendance->task_report, true);

                if (is_array($tasks)) {
                    $totalTasks += count($tasks);
                }

                return $totalTasks;
            }, 0);



            return view('admin.backend.pages.dashboard.index', [
                "present_this_month" => $present_this_month,
                "task_this_month" => $task_this_month
            ]);
        }
    }
}
