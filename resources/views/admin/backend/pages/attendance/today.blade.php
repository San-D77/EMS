@extends('admin.backend.layouts.index')
@section('content')
    @push('styles')
        <link href="{{ asset('backend/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
        <link href="{{ asset('backend/assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
        <link href="{{ asset('backend/assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('backend/assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    @endpush

    @push('scripts')
        <script src="{{ asset('backend/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
        <script src="{{ asset('backend/assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('backend/assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
        <script>
            $(function() {
                'use strict';

                function initializeDataTable(selector) {
                    if (!$.fn.DataTable.isDataTable(selector)) {
                        $(selector).DataTable({
                            "aLengthMenu": [
                                [10, 30, 50, -1],
                                [10, 30, 50, "All"]
                            ],
                            "iDisplayLength": 10,
                            "language": {
                                search: ""
                            }
                        }).each(function() {
                            var datatable = $(this);
                            var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
                            search_input.attr('placeholder', 'Search');
                            search_input.removeClass('form-control-sm');
                            var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
                            length_sel.removeClass('form-control-sm');
                        });
                    }
                }

                // Initialize the DataTable for the active tab on page load
                initializeDataTable('#example2');

                // Initialize the DataTable when a tab is shown
                $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
                    var target = $(e.target).attr("href"); // activated tab
                    initializeDataTable(target + ' table');
                });
            });
        </script>
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
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div style="margin: 10px; font-size: 18px; font-weight: 600; color: green;">Total Present Today:
                {{ count($presents) }}</div>
            <div class="card">
                @include('notification')
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example2" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>S.N.</th>
                                    <th>Employee Name</th>
                                    <th>Login Time</th>
                                    <th>Log_In IP</th>
                                    <th>Logout Time</th>
                                    <th>Time Stayed</th>
                                    <th>Logout IP</th>
                                    <th>Tasks</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody class="report-data">
                                @foreach ($presents as $single_attendance)
                                    <tr style="background:#b6dde9 !important; font-size: 17px; font-weight:600;">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $single_attendance->user->name }}</td>
                                        <td>{{ $single_attendance->session_start }}</td>
                                        <td>{{ $single_attendance->login_location }}</td>
                                        <td>{{ $single_attendance->session_end }}</td>
                                        <td class="{{ strtotime($single_attendance->duration) < strtotime($single_attendance->user->standard_time) ? 'less-time' : '' }}">
                                            {{ $single_attendance->duration }}
                                        </td>
                                        <td>{{ $single_attendance->logout_location }}</td>
                                        <td class="{{ $single_attendance->task_report && count(json_decode($single_attendance->task_report)) < (int) $single_attendance->user->standard_task ? 'less-task' : '' }}">
                                            {{ $single_attendance->task_report ? count(json_decode($single_attendance->task_report)) : '' }}
                                        </td>
                                        <td>
                                            @if ($single_attendance->task_report)
                                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                                    data-target="#reportModal{{ $loop->iteration }}">
                                                    View
                                                </button>
                                                <div class="modal fade" id="reportModal{{ $loop->iteration }}"
                                                    tabindex="-1" role="dialog"
                                                    aria-labelledby="reportModal{{ $loop->iteration }}CenterTitle"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header" style="text-align: center;">
                                                                <h5 class="modal-title" id="reportModal{{ $loop->iteration }}LongTitle">
                                                                    Report of
                                                                    <span style="color:green;">{{ ucfirst($single_attendance->user->name) }}</span>
                                                                    for <span style="color:#084799">{{ $single_attendance->day }}</span>
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
                                                                            <span class="title">Title:</span><span>{{ $task->title }}</span>
                                                                            @if (isset($task->remarks))
                                                                                <span class="title">Remarks:</span><span class="remarks">
                                                                                    {{ $task->remarks }}</span>
                                                                            @endif
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <form action="{{ route('backend.attendance-take_action', [$single_attendance->id, 'approved']) }}" method="post">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-success">Approve</button>
                                                                </form>
                                                                <form action="{{ route('backend.attendance-take_action', [$single_attendance->id, 'needs-attention']) }}" method="post">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-warning">Needs Attention</button>
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
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div style="margin: 10px; font-size: 18px; font-weight: 600; color: maroon;">Total Absent Today:
                {{ count($absents) }}</div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example2" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>S.N.</th>
                                    <th>Employee Name</th>
                                </tr>
                            </thead>
                            <tbody class="report-data">
                                @foreach ($absents as $single_attendance)
                                    <tr style="background:#e48d87 !important; font-size: 17px; font-weight:600;">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $single_attendance->name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
