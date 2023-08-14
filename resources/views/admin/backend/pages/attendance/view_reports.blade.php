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

    <div style="display:flex;justify-content:center; font-size:19px; font-weight:600; color: #009200;">Task reports
        of
        {{ count($full_time_reports) > 0 ? $full_time_reports[0]->day : (count($unsubmitted) > 0 ? $unsubmitted[0]->day : '') }}
    </div>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="full-time-tab" data-bs-toggle="tab" data-bs-target="#full-time" type="button"
                role="tab" aria-controls="full-time" aria-selected="true">Full Time Employees</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="part-time-tab" data-bs-toggle="tab" data-bs-target="#part-time" type="button"
                role="tab" aria-controls="part-time" aria-selected="false">Part Time Employees</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="unsubmitted-tab" data-bs-toggle="tab" data-bs-target="#unsubmitted" type="button"
                role="tab" aria-controls="unsubmitted" aria-selected="false">Unsubmitted</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="individual-tab" data-bs-toggle="tab" data-bs-target="#individual" type="button"
                role="tab" aria-controls="individual" aria-selected="false">Individual Reports</button>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active " id="full-time" role="tabpanel" aria-labelledby="full-time-tab">

            <table class="table table-striped" style=" ">
                <thead>
                    <th>S.N.</th>
                    <th>Employee Name</th>
                    <th>Arrival</th>
                    <th>Log_In IP</th>
                    <th>Departure</th>
                    <th>Log_Out IP</th>
                    <th>Stay Time</th>
                    <th>Task Count</th>
                    <th>Report Status</th>
                    <th>Action</th>
                </thead>
                <tbody class="report-data">
                    @if ($full_time_reports !== null)
                        @foreach ($full_time_reports as $single_attendance)
                            <tr
                                style="vertical-align:middle; background:#b6dde9 !important; font-size: 17px; font-weight:600;">
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                <td style="color:green;">{{ $single_attendance->user->name }}</td>
                                <td>{{ $single_attendance->session_start }}</td>
                                <td>{{ $single_attendance->login_location }}</td>
                                <td>{{ $single_attendance->session_end }}</td>
                                <td>{{ $single_attendance->logout_location }}</td>
                                <td
                                    class="
                                            {{ strtotime($single_attendance->duration) < strtotime($single_attendance->user->standard_time)
                                                ? 'less-time'
                                                : '' }}
                                        ">
                                    {{ $single_attendance->duration }}</td>
                                <td style="color:rgb(32, 7, 29);"
                                    class="{{ count(json_decode($single_attendance->task_report)) < (int) $single_attendance->user->standard_task ? 'less-task' : '' }}">
                                    {{ count(json_decode($single_attendance->task_report)) }}
                                </td>
                                <td>{{ ucfirst($single_attendance->report_status) }}</td>
                                <td>
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
                                                                        class="remarks"> {{ $task->remarks }}</span>
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

                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="part-time" role="tabpanel" aria-labelledby="part-time-tab">

            <table class="table table-striped" style="table-layout: fixed; ">
                <thead>
                    <th>S.N.</th>
                    <th>Employee Name</th>
                    <th>Task Count</th>
                    <th>Report Status</th>
                    <th>Aciton</th>
                </thead>
                <tbody class="report-data">
                    @foreach ($part_time_reports as $single_attendance)
                        <tr
                            style="vertical-align:middle; background:#b6dde9 !important; font-size: 17px; font-weight:600;">
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td style="color:green;">{{ $single_attendance->user->name }}</td>
                            <td style="color:rgb(32, 7, 29);">
                                {{ count(json_decode($single_attendance->task_report)) }}
                            </td>
                            <td>{{ ucfirst($single_attendance->report_status) }}</td>
                            <td>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                    data-target="#parttimereportModal{{ $loop->iteration }}">
                                    View
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="parttimereportModal{{ $loop->iteration }}" tabindex="-1"
                                    role="dialog" aria-labelledby="parttimereportModal{{ $loop->iteration }}CenterTitle"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header" style="text-align: center;">
                                                <h5 class="modal-title" id="parttimereportModal{{ $loop->iteration }}LongTitle">
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
                                                                <span class="title">Remarks:</span><span class="remarks">
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

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="unsubmitted" role="tabpanel" aria-labelledby="unsubmitted-tab">

            <table class="table table-striped" style="table-layout: fixed; ">
                <thead>
                    <th>S.N.</th>
                    <th>Employee Name</th>
                    <th>Employment Type</th>
                </thead>
                <tbody class="report-data">
                    @foreach ($unsubmitted as $single_attendance)
                        <tr
                            style="vertical-align:middle; background:#b6dde9 !important; font-size: 17px; font-weight:600;">
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td style="color:green;">{{ $single_attendance->user->name }}</td>
                            <td>{{ ucfirst($single_attendance->user->employment_type) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="individual" role="tabpanel" aria-labelledby="individual-tab">

            <table class="table table-striped" style="table-layout: fixed; ">
                <thead>
                    <th>S.N.</th>
                    <th>Employee Name</th>
                    <th>Present</th>
                    <th>Absent</th>
                    <th>Leave Remaining</th>
                    <th>Action</th>
                </thead>
                <tbody class="report-data">
                    @foreach ($attendance_data as $user)
                        <tr style="background:#8cd1ec !important; font-size: 16px; font-weight:600;">
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>
                                {{ $user->total_attendance_days }}
                            </td>
                            <td>
                                {{ $working_days - $user->total_attendance_days }}
                            </td>
                            <td>
                                {{ $working_days - $user->total_attendance_days < 2 ? 2 - ($working_days - $user->total_attendance_days) : 0 }}
                            </td>
                            <td>
                                <a href="{{ route('backend.attendance-individual_report', $user->id) }}"
                                    class="btn btn-sm btn-warning">View Report</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
