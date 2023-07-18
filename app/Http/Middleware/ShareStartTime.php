<?php

namespace App\Http\Middleware;

use App\Models\Backend\Attendance;
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
        $user = Attendance::where('user_id',Auth::user()?->id)
        ->whereDate('created_at', $today)
        ->whereNull('session_end')->first();

        $submitted =  Attendance::where('user_id',Auth::user()?->id)
                        ->whereDate('created_at', $today)
                        ->whereNotNull('session_end')->first();

        view()->share(["start_time" => $user?->session_start, "submitted" => $submitted? true : false]);

        return $next($request);
    }
}
