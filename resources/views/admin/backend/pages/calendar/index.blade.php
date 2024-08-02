@extends('admin.backend.layouts.index')
@section('content')
    @push('styles')
        <!--plugins-->
        <link href="{{ asset('backend') }}/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
        <link href="{{ asset('backend') }}/assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
        <link href="{{ asset('backend') }}/assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
        <link href="{{ asset('backend') }}/assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    @endpush

    @push('scripts')
        <!--plugins-->

        <script src="{{ asset('backend') }}/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
        <script src="{{ asset('backend') }}/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
        <script src="{{ asset('backend') }}/assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
        <script src="{{ asset('backend') }}/assets/js/table-datatable.js"></script>
    @endpush
    <div class="card">
        @include('notification')
        <div class="card-body">
            <div class="table-responsive">
                <table id="example2" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>S.N.</th>
                            <th>Year</th>
                            <th>Month</th>
                            <th>First Day</th>
                            <th>Last Day</th>
                            <th>Action</th>
                        </tr>
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
                                <th><a href="{{ route('backend.calendar-edit', $single_date->id) }}"
                                        class="btn btn-sm btn-warning">Edit</a></th>
                            </tr>
                        @endforeach


                    </tbody>
                   
                </table>
            </div>
        </div>
    </div>
@endsection
