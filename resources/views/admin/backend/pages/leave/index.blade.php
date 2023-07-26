@extends('admin.backend.layouts.index')
@section('content')
    <table class="table table-striped">
        <thead>
            <th>S.N.</th>
            <th>Employee Name</th>
            <th>Leave For</th>
            <th>Status</th>
            <th>Action</th>
        </thead>
        <tbody class="report-data">
            @foreach ($pending_leaves as $single_leave)
                <tr>
                    <td style="vertical-align: middle;">
                        {{ $loop->iteration }}
                    </td>
                    <td style="vertical-align: middle;">{{ ucfirst($single_leave->user->name) }}</td>
                    <td style="vertical-align: middle;">
                        {{ $single_leave->leave_type == 'one-day' ? $single_leave->date : $single_leave->first_day . ' to ' . $single_leave->last_day }}
                    </td>
                    <td style="vertical-align: middle;">{{ ucfirst($single_leave->status) }}</td>
                    <td style="vertical-align: middle;">

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                            data-target="#leaveModal{{ $loop->iteration }}">
                            Take Action
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="leaveModal{{ $loop->iteration }}" tabindex="-1" role="dialog"
                            aria-labelledby="leaveModal{{ $loop->iteration }}CenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="leaveModal{{ $loop->iteration }}LongTitle">
                                            Leave for
                                            {{ ucfirst($single_leave->user->name) }}
                                            {{ $single_leave->leave_type == 'one-day' ? ' for ' . $single_leave->date : ' from ' . $single_leave->first_day . ' to ' . $single_leave->last_day }}
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body" style="white-space: normal; word-wrap: break-word;">
                                        <div style="font-size: 18px; text-align: center; font-weight:600;">Description
                                        </div>
                                        <div>
                                            <p style="position:relative;">{{ $single_leave->description }}</p>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <form action="{{ route('backend.leave-approve', $single_leave->id) }}"
                                            method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-success">Approve</button>
                                        </form>
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                            data-target="#messageModal{{ $loop->iteration }}">
                                            Reject
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="messageModal{{ $loop->iteration }}" tabindex="-1"
                                            role="dialog" aria-labelledby="messageModal{{ $loop->iteration }}CenterTitle"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div style="height: 300px;" class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="messageModal{{ $loop->iteration }}LongTitle">
                                                            Write a Message
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('backend.leave-reject', $single_leave->id) }}"
                                                        method="post">
                                                        @csrf
                                                        <div class="modal-body"
                                                            style="white-space: normal; word-wrap: break-word;">
                                                            <div class="mt-5">
                                                                <input class="form-control" type="text" name="message"
                                                                    id=""
                                                                    placeholder="Send message in case of rejection">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-danger">Send</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
