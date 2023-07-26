@extends('admin.backend.layouts.index')
@section('content')
@push('styles')
    <style>
        .rejected{
            color:red !important;
            font-weight: 600;
        }
        .pending{
            color:orange !important;
            font-weight: 600;
        }
        .approved{
            color:green !important;
            font-weight: 600;
        }
    </style>
@endpush
    <table class="table table-striped">
        <thead>
            <th>S.N.</th>
            <th>Leave Type</th>
            <th>Date</th>
            <th>Date in BS</th>
            <th>Description</th>
            <th>Status</th>
            <th>Message</th>
        </thead>
        <tbody class="report-data">
            @foreach ($leaves as $leave)
                <tr>
                    <td>
                        {{ $loop->iteration }}
                    </td>
                    <td>{{ ucwords(str_replace('-',' ',$leave->leave_type)) }}</td>
                    <td>{{ $leave->date }}</td>
                    <td>{{ toBikramSambatDate($leave->date) }}</td>
                    <td>{{ $leave->description }}</td>
                    <td class="{{ ($leave->status == 'pending')? 'pending' : (($leave->status == 'approved')? 'approved' : 'rejected') }}">{{ ucfirst($leave->status) }}</td>
                    <td>{{ $leave->message }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
