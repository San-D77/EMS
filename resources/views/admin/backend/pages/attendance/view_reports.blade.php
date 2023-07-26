@extends('admin.backend.layouts.index')
@section('content')
    <div>
        <div>Place Selector here</div>
    </div>
    <div style="display:flex;justify-content:center; font-size:19px; font-weight:600; color: #009200;">Task Reports of {{ count($reports) > 0 ? $reports[0]->day : ( count($unsubmitted) > 0 ? $unsubmitted[0]->day : '') }}</div>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button"
                role="tab" aria-controls="home" aria-selected="true">Reports</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button"
                role="tab" aria-controls="profile" aria-selected="false">Unsubmitted</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="individual-tab" data-bs-toggle="tab" data-bs-target="#individual" type="button"
                role="tab" aria-controls="individual" aria-selected="false">Individual</button>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active " id="home" role="tabpanel" aria-labelledby="home-tab">

            <table class="table table-striped" style=" ">
                <thead>
                    <th>S.N.</th>
                    <th>Employee Name</th>
                    <th>Task Report</th>
                    <th>Report Status</th>
                </thead>
                <tbody class="report-data" >
                    @if($reports !== null)
                        @foreach ($reports as $single_attendance)
                            <tr
                                style="vertical-align:middle; background:#b6dde9 !important; font-size: 17px; font-weight:600;">
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                <td style="color:green;">{{ $single_attendance->user->name }}</td>
                                <td style="color:rgb(32, 7, 29);">
                                    @if ( $single_attendance->task_report)
                                        <ol>
                                            @foreach ( json_decode($single_attendance->task_report) as $task)
                                                <li style="margin-bottom:7px;">
                                                    {{ $task->title }}</span><br>
                                                </li>
                                            @endforeach
                                        </ol>
                                    @else
                                        Unsubmitted
                                    @endif
                                </td>
                                <td>{{ ucfirst($single_attendance->report_status) }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

            <table class="table table-striped" style="table-layout: fixed; ">
                <thead>
                    <th>S.N.</th>
                    <th>Employee Name</th>
                    <th>Task Report</th>
                    <th>Report Status</th>
                </thead>
                <tbody class="report-data">
                    @foreach ($unsubmitted as $single_attendance)
                        <tr
                            style="background:#b6dde9 !important; font-size: 17px; font-weight:600;">
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>{{ $single_attendance->user->name }}</td>
                            <td>{{ $single_attendance->task_report ? $single_attendance->task_report : 'Unsubmitted' }}</td>
                            <td>{{ $single_attendance->report_status }}</td>
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
                    <th>Action</th>
                </thead>
                <tbody class="report-data">
                    @foreach ($users as $user)
                        <tr
                            style="background:#8cd1ec !important; font-size: 16px; font-weight:600;">
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>
                                <a href="{{ route('backend.attendance-individual_report', Auth::user()->id) }}" class="btn btn-sm btn-warning">View Report</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
