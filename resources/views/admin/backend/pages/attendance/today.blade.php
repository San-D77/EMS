@extends('admin.backend.layouts.index')
@section('content')
    @push('styles')
        <style>
            .table-striped>tbody>tr>td.less-task {
                background: #eb7777;
                padding: 10px;
                color: #494949 !important;
                --bs-table-striped-bg: #eb7777;
            }

            .table-striped>tbody>tr>td.less-time {
                background: #ebbd77;
                padding: 10px;
                color: #494949 !important;
                --bs-table-striped-bg: #ebbd77;
            }

            .single-task {
                /* border: 1px solid #ff9c9c; */
                border-radius: 5px;
                padding: 15px;
                margin-bottom: 10px;
                box-shadow: 0 4px 4px 0 rgba(0, 0, 0, 0.5);
                color: #1269da;
                font-size: 16px;
                line-height: 25px;
                font-weight: 500;
            }

            .remarks {
                color: #4f0fff;
                display: block;
                margin-top: 15px;
            }

            .title {
                display: block;
                color: green;
                margin: 10px 0px;
            }
        </style>
    @endpush
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button"
                role="tab" aria-controls="home" aria-selected="true">Present</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button"
                role="tab" aria-controls="profile" aria-selected="false">Absent</button>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active " id="home" role="tabpanel" aria-labelledby="home-tab">
            <div style="margin: 10px; font-size: 18px; font-weight: 600; color: green;">Total Present Today:
                {{ count($presents) }}</div>
            <table class="table table-striped" style="table-layout: fixed; ">
                <thead>
                    <th>S.N.</th>
                    <th>Employee Name</th>
                    <th>Login Time</th>
                    <th>Log_In IP</th>
                    <th>Logout Time</th>
                    <th>Time Stayed</th>
                    <th>Logout IP</th>
                    <th>Tasks</th>
                </thead>
                <tbody class="report-data">
                    @foreach ($presents as $single_attendance)
                        <tr style="background:#b6dde9 !important; font-size: 17px; font-weight:600;">
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>{{ $single_attendance->user->name }}</td>
                            <td>{{ $single_attendance->session_start }}</td>
                            <td>{{ $single_attendance->login_location }}</td>
                            <td>{{ $single_attendance->session_end }}</td>
                            <td
                                class="
                                            {{ strtotime($single_attendance->duration) < strtotime($single_attendance->user->standard_time)
                                                ? 'less-time'
                                                : '' }}
                                        ">
                                {{ $single_attendance->duration }}</td>
                            <td>{{ $single_attendance->logout_location }}</td>
                            <td style="color:rgb(32, 7, 29);"
                                class="{{ $single_attendance->task_report ? (count(json_decode($single_attendance->task_report)) < (int) $single_attendance->user->standard_task ? 'less-task' : '') : '' }}">
                                {{ $single_attendance->task_report ? count(json_decode($single_attendance->task_report)) : '' }}
                            </td>
                            <td>
                                @if ($single_attendance->task_report)
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                        data-target="#reportModal{{ $loop->iteration }}">
                                        View
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="reportModal{{ $loop->iteration }}" tabindex="-1"
                                        role="dialog" aria-labelledby="reportModal{{ $loop->iteration }}CenterTitle"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header" style="text-align: center;">
                                                    <h5 class="modal-title"
                                                        id="reportModal{{ $loop->iteration }}LongTitle">
                                                        Report of
                                                        <span
                                                            style="color:green;">{{ ucfirst($single_attendance->user->name) }}</span>
                                                        for <span style="color:#084799">
                                                            {{ $single_attendance->day }}</span>

                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body" style="white-space: normal; word-wrap: break-word;">
                                                    <div>

                                                        @foreach (json_decode($single_attendance->task_report) as $task)
                                                            <div class="single-task">
                                                                <span
                                                                    class="title">Title:</span><span>{{ $task->title }}</span>
                                                                @if (isset($task->remarks))
                                                                    <span class="title">Remarks:</span><span
                                                                        class="remarks">
                                                                        {{ $task->remarks }}</span>
                                                                @endif
                                                            </div>
                                                        @endforeach

                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <form
                                                        action="{{ route('backend.attendance-take_action', [$single_attendance->id, 'approved']) }}"
                                                        method="post">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success">Approve</button>
                                                    </form>
                                                    <form
                                                        action="{{ route('backend.attendance-take_action', [$single_attendance->id, 'needs-attention']) }}"
                                                        method="post">
                                                        @csrf
                                                        <button type="submit" class="btn btn-warning">Needs
                                                            Attention</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div style="margin: 10px; font-size: 18px; font-weight: 600; color: maroon;">Total Absent Today:
                {{ count($absents) }}</div>
            <table class="table table-striped" style="table-layout: fixed; ">
                <thead>
                    <th>S.N.</th>
                    <th>Employee Name</th>
                </thead>
                <tbody class="report-data">
                    @foreach ($absents as $single_attendance)
                        <tr style="background:#e48d87 !important;  font-size: 17px; font-weight:600; padding-left: 10px;">
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>{{ $single_attendance->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
