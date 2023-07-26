<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\LeaveRequest;
use App\Models\Backend\Leave;
use App\Models\User;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    public function create()
    {
        return view('admin.backend.pages.leave.crud');
    }
    public function store(LeaveRequest $request, User $user)
    {
        $final_array = [];
        $final_array['leave_type'] = $request['leave-type'];
        $final_array['user_id'] = $user->id;
        $final_array['description'] = $request['description'];
        $final_array['status'] = 'pending';
        if ($request['leave-type'] == 'one-day') {
            $final_array['date'] = $request['date'];
        } else {
            $final_array['first_day'] = $request['first_day'];
            $final_array['last_day'] = $request['last_day'];
        }
        Leave::create($final_array);
        return redirect()->route('backend.dashboard');
    }

    public function index(){
        return view('admin.backend.pages.leave.index',[
            'pending_leaves' => Leave::where('status','pending')->with('user')->get()
        ]);

    }

    public function approve(Leave $leave){
        $leave->update([
            'status' => "approved"
        ]);
        return back();
    }
    public function reject(Leave $leave){

        $leave->update([
            'status' => "rejected",
            'message' => request()->input('message')
        ]);
        return back();
    }

    public function individual(User $user){
        return view('admin.backend.pages.leave.individual', [
            "leaves" => Leave::where('user_id', $user->id)->get()
        ]);
    }
}
