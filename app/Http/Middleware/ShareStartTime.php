<?php

namespace App\Http\Middleware;

use App\Models\Backend\Attendance;
use App\Models\Backend\Leave;
use App\Models\Backend\Notice;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ShareStartTime
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $today = now()->toDateString();
        $user = Attendance::where('user_id', Auth::user()?->id)
            ->whereDate('created_at', $today)
            ->whereNull('session_end')->first();



        $submitted =  Attendance::where('user_id', Auth::user()?->id)
            ->whereDate('created_at', $today)
            ->whereNotNull('session_end')->first();

        $pending_leaves = Leave::where('status', 'pending')->count();

        $user2 = Auth::user();
        $userId = optional($user2)->id;
        $pending_notices = $userId ? Notice::whereRaw("Not JSON_CONTAINS(viewed_by, CAST($userId AS JSON))")->count()  : '';
        // dd($pending_notices);

        view()->share([
            "start_time" => $user?->session_start,
            "submitted" => $submitted ? true : false,
            "pending_leave_count" => $pending_leaves,
            "pending_notice_count" => $pending_notices
        ]);

        return $next($request);
    }
}
