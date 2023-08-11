@extends('admin.backend.layouts.index')
@section('content')
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
            <div style="margin: 10px; font-size: 18px; font-weight: 600; color: green;">Total Present Today: {{ count($presents) }}</div>
            <table class="table table-striped" style="table-layout: fixed; ">
                <thead>
                    <th>S.N.</th>
                    <th>Employee Name</th>
                    <th>Session Start</th>
                    <th>Log_In IP</th>
                </thead>
                <tbody class="report-data">
                    @foreach ($presents as $single_attendance)
                        <tr
                            style="background:#b6dde9 !important; font-size: 17px; font-weight:600;">
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>{{ $single_attendance->user->name }}</td>
                            <td>{{ $single_attendance->session_start }}</td>
                            <td>{{ $single_attendance->login_location }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div style="margin: 10px; font-size: 18px; font-weight: 600; color: maroon;">Total Absent Today: {{ count($absents) }}</div>
            <table class="table table-striped" style="table-layout: fixed; ">
                <thead>
                    <th>S.N.</th>
                    <th>Employee Name</th>
                </thead>
                <tbody class="report-data">
                    @foreach ($absents as $single_attendance)
                        <tr
                            style="background:#e48d87 !important;  font-size: 17px; font-weight:600; padding-left: 10px;">
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
