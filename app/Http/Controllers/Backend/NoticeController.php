<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\NoticeRequest;
use App\Models\Backend\Notice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pusher\Pusher;

class NoticeController extends Controller
{

    public function create()
    {
        return view('admin.backend.pages.notice.crud');
    }

    public function store(NoticeRequest $request)
    {

        Notice::create($request->validated());

        // Trigger real-time notification to the admin
        $data = [
            'message' => 'new-notice'
        ];

        pusherTemplate('notification-channel', 'new-announcement', $data);


        return redirect()->route('backend.notice-view');
    }

    public function edit(Notice $notice)
    {
        return view('admin.backend.pages.notice.crud', [
            "notice" => $notice
        ]);
    }

    public function update(NoticeRequest $request, Notice $notice)
    {
        $notice->update($request->validated());
        return redirect()->route('backend.notice-view');
    }

    public function view()
{
    $user = Auth::user();
    $userCreatedAt = $user->created_at;

    $notices = Notice::where('created_at', '>=', $userCreatedAt)
        ->orderBy('created_at', 'desc')
        ->get();

    return view('admin.backend.pages.notice.index', [
        "notices" => $notices
    ]);
}

    public function view_single(Notice $notice, User $user)
    {
        // Step 1: Retrieve the current viewed_by value and convert it to an array
        $viewedBy = $notice->viewed_by ? $notice->viewed_by : [];
        // Step 2: Check if the user ID already exists in the array
        if (!in_array($user->id, $viewedBy)) {
            // Step 3: If the user ID does not exist, add it to the array
            $viewedBy[] = $user->id;
            $notice->update([
                'viewed_by' => $viewedBy
            ]);
        }



        if ($user->id && $user->created_at) {
            $pending_notices = Notice::whereRaw("Not JSON_CONTAINS(viewed_by, CAST(? AS JSON))", [$user->id])
                ->where('created_at', '>=', $user->created_at)
                ->count();
        }




        return view('admin.backend.pages.notice.view_single', [
            'notice' => $notice,
            'pending_notice_count' => $pending_notices
        ]);
    }

    public function terminate_notice(Notice $notice)
    {
        $update_option = $notice->terminate_notice == '1' ? '0' : '1';
        $notice->update([
            "terminate_notice" => $update_option
        ]);
        return back();
    }
}
