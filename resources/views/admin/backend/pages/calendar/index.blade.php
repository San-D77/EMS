@extends('admin.backend.layouts.index')
@section('content')

    <table class="table table-striped">
        <thead>
            <th>S.N.</th>
            <th>Year</th>
            <th>Month</th>
            <th>First Day</th>
            <th>Last Day</th>
            <th>Action</th>
        </thead>
        <tbody class="report-data">
            @foreach ($calendar as $single_date)
                <tr>
                    <td>
                        {{ $loop->iteration }}
                    </td>
                    <th>{{ $single_date->year }}</th>
                    <th>{{ ucfirst($single_date->month) }}</th>
                    <th>{{ $single_date->first_day }}</th>
                    <th>{{ $single_date->last_day }}</th>
                    <th><a href="{{ route('backend.calendar-edit', $single_date->id) }}" class="btn btn-sm btn-warning">Edit</a></th>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
