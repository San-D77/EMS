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
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>

                                <td>
                                    <a href="{{ route('backend.user-update_status', $user->id) }}"
                                        class="btn btn-sm btn-{{ $user->status == 1 ? 'success' : 'danger' }}">
                                        {{ $user->status == 1 ? 'Active' : 'InActive' }}
                                    </a>

                                </td>

                                <td>
                                    <a href="{{ route('backend.user-edit', $user->id) }}"
                                        class="btn btn-primary btn-sm">Edit</a>
                                </td>
                            </tr>
                        @endforeach


                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
