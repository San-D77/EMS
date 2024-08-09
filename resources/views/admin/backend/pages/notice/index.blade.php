@php
    $role_slug = Auth::user()->role->slug;
@endphp
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
        <div class="card-body">
            <div class="table-responsive">
                <table id="example2" class="table table-striped table-bordered">
                    <thead>
                        <th>S.N.</th>
                        <th>Date</th>
                        <th>Title</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach ($notices as $notice)
                            @php
                                $viewed = in_array(Auth::user()->id, $notice->viewed_by);
                            @endphp
                            <tr {{ $viewed ? 'class=viewed' : '' }}>
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                <td>{{ toBikramSambatDate($notice->created_at) }}</td>
                                <td>{{ $notice->title }}</td>
                                <td>
                                    <a href="{{ route('backend.notice-view_single', [$notice->id, Auth::user()->id]) }}"
                                        class="btn btn-sm btn-success">
                                        view
                                    </a>
                                    @if ($role_slug == 'admin' || $role_slug == 'superadmin')
                                        <a href="{{ route('backend.notice-edit', [$notice->id]) }}"
                                            class="btn btn-sm btn-warning">edit</a>
                                    @endif
                                    @if ($role_slug == 'admin' || $role_slug == 'superadmin')
                                        <a href="{{ route('backend.notice-terminate_notice', [$notice->id]) }}"
                                            class="btn btn-sm {{ $notice->terminate_notice == '1' ? 'btn-primary' : 'btn-danger' }}">
                                            @if ($notice->terminate_notice == 1)
                                                reshow
                                            @else
                                                terminate
                                            @endif
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
