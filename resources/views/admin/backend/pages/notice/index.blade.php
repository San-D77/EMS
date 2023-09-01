@extends('admin.backend.layouts.index')
@section('content')
    @push('styles')
        <style>
            .table td {
                vertical-align: middle;
            }

            .table-striped tbody tr,
            .table-striped tbody tr:nth-of-type(odd)>* {
                color: black;
                font-weight: 800;
                font-size: 16px;
            }

            .table-striped tbody tr.viewed,
            .table-striped tbody tr.viewed:nth-of-type(odd)>* {
                font-weight: 400 !important;
            }
        </style>
    @endpush
    <table class="table table-striped" style="table-layout:fixed;">
        <thead>
            <th>S.N.</th>
            <th>Date</th>
            <th>Title</th>
            <th>Action</th>
        </thead>
        <tbody class="report-data">
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
                        @if (Auth::user()->role->slug == 'admin')
                            <a href="{{ route('backend.notice-edit', [$notice->id])}}" class="btn btn-sm btn-warning">edit</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
