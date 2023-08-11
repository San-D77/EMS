<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Attendance;
use App\Models\Backend\Leave;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $present_today = Attendance::whereDate('created_at', $today)
                        ->get();
        $on_leave = Leave::where(function ($query) use ($today) {
            $query->whereDate('date', $today)
                  ->orWhere(function ($subQuery) use ($today) {
                      $subQuery->whereDate('first_day', '<=', $today)
                               ->whereDate('last_day', '>=', $today);
                  });
        })
        ->where('status', 'approved')->get();
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
    }
}
