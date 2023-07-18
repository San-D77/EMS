@extends('admin.backend.layouts.index')
@section('content')
    <table class="table table-striped">
        <thead>
            <th>S.N.</th>
            <th>Date</th>
            <th>Employee Name</th>
            <th>Task Report</th>
            <th></th>
        </thead>
        <tbody class="report-data">
            @foreach ($reports as $single_attendance)
                <tr>
                    <td>
                        {{ $loop->iteration }}
                    </td>
                    <td>{{ $single_attendance->day }}</td>
                    <td>{{ $single_attendance->session_start }}</td>
                    <td>{{ $single_attendance->session_end }}</td>
                    <td>{{ $single_attendance->duration }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
