<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function register_attendance(User $user,){
        Attendance::create([
            'user_id' => $user->id,
            'day' => toBikramSambatDate(now()),
            'session_start' => \Carbon\Carbon::now()->format('H:i:s'),
            'location' => 'Baluwatar'
        ]);
        return back();
    }

    public function terminate_session(User $user,){
        $today = now()->toDateString();
        $user = Attendance::where('user_id',$user->id)
        ->whereDate('created_at', $today)
        ->whereNotNull('session_end')->first();

        return view('admin.backend.pages.tasks.crud',[
            'alreadySubmitted' => $user ? 'true' : false
        ]);
    }

    public function save_tasks(Request $request, User $user){
        $requestData = $request->tasks;

        $today = now()->toDateString();

        $user = Attendance::where('user_id',$user->id)
        ->whereDate('created_at', $today)
        ->whereNull('session_end')->first();


        $currentDateTime = now();
        $previousDateTime = $user->created_at;

        $timeDifference = strtotime($currentDateTime) - strtotime($previousDateTime);

        $hours = floor($timeDifference / (60 * 60));
        $minutes = floor(($timeDifference % (60 * 60)) / 60);
        $seconds = $timeDifference % 60;

        $time_duration = $hours.':'.$minutes.':'.$seconds;


        $user->update([
            'session_end' => \Carbon\Carbon::now()->format('H:i:s'),
            'duration' => $time_duration,
            'location' => 'Ghantaghar',
            'task_report' => $requestData,
            'report_status' => 'pending'
        ]);

        // Return the response
        return response()->json([
            'result' => 'successful'
        ]);
    }

    public function view_reports(){
        return view('admin.backend.pages.attendance.view_reports',[
            "reports" => Attendance::whereDate('created_at', Carbon::yesterday()->toDateString()),
        ]);
    }

    public function view(User $user){
        $user_attendance = Attendance::where('user_id', $user->id)
                                    ->whereMonth('created_at', Carbon::now()->month)
                                    ->orderBy('created_at','desc')
                                    ->get();
        return view('admin.backend.pages.attendance.view_report',[
            'user_attendance' => $user_attendance
        ]);
    }

    public function generate_report(Request $request, User $user){
        $results = Attendance::where('user_id',$user->id)
                            ->whereDate('created_at','>=',$request->start_date )
                            ->whereDate('created_at','<=',$request->end_date)
                            ->orderBy('session_start','desc')
                            ->get();
        return response()->json([
           'data' => $results
        ]);
    }
}
