@extends('admin.backend.layouts.index')
@section('content')
    @push('styles')
        <style>
            .present-name {
                font-size: 16px;
                font-weight: 500;
                color: rgb(35, 112, 99);
            }

            .on_leave-name {
                font-size: 16px;
                font-weight: 500;
                color: rgb(218, 119, 39);
            }

            .absent-name {
                font-size: 16px;
                font-weight: 500;
                color: rgb(218, 83, 42);
            }

            .single-leave {
                padding: 10px;
                border: 1px solid #e0e0e0;
                border-radius: 5px;
                box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, .1);
            }

            .single-leave .reason {
                margin-left: 10px;
            }

            .notice-box {
                margin: 30px 50px;
                padding: 20px 15px;
                border-radius: 5px;
                background: #fff;
                box-shadow: 0px 4px 6px rgba(0, 0, 0, .4);

            }

            .notice-title {
                text-align: center;
                font-size: 25px;
                font-weight: 700;
                color: #2cbb01;
                padding: 15px;
                text-transform: capitalize;
            }

            .notice-description {
                font-size: 18px;
                font-weight: 500;
                color: #04a5d6;
                padding: 50px 80px;
            }
        </style>
    @endpush
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Welcome to Dashboard</h4>
        </div>
    </div>

    @if ($notice && !in_array(Auth::user()->id, $notice->viewed_by))
        <div class="notice-box">
            <h2 class="notice-title">{{ $notice->title }}</h2>
            <div class="notice-description">
                {!! $notice->description !!}
            </div>
        </div>
    @endif

    @if (Auth::user()->role->slug == 'admin' ||
            Auth::user()->role->slug == 'superadmin' ||
            Auth::user()->role->slug == 'supervisor')
        <div class="row">
            <div class="col-12 col-xl-12 stretch-card">
                <div class="row flex-grow-1">
                    <div class="col-md-4 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-baseline">
                                    <h6 class="card-title mb-0">Present Today</h6>
                                    <span>
                                        <!-- Button trigger modal -->
                                        <button style="background:transparent; color:green; border:none;" type="button"
                                            class="btn btn-sm btn-primary" data-toggle="modal" data-target="#presentModal">
                                            <i class="link-icon" data-feather="eye"></i>
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="presentModal" tabindex="-1" role="dialog"
                                            aria-labelledby="presentModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header" style="text-align: center;">
                                                        <h5 class="modal-title" id="presentModalLongTitle">
                                                            Present Today
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body"
                                                        style="white-space: normal; word-wrap: break-word;">
                                                        <div>
                                                            @foreach ($present_today as $present)
                                                                <p class="present-name">{{ $present->user->name }}</p>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </span>
                                </div>
                                <div class="row">
                                    <div class="col-6 col-md-12 col-xl-5">

                                        <div class="d-flex align-items-baseline">
                                            <p class="text-success">
                                            <h3 style="color:green;" class="mb-2 mt-4">{{ count($present_today) }}</h3>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-12 col-xl-7">
                                        <div id="customersChart" class="mt-md-3 mt-xl-0"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-baseline">
                                    <h6 class="card-title mb-0">On Leave</h6>
                                    <span>
                                        <!-- Button trigger modal -->
                                        <button style="background:transparent; color:orange; border:none;" type="button"
                                            class="btn btn-sm btn-primary" data-toggle="modal" data-target="#on_leaveModal">
                                            <i class="link-icon" data-feather="eye"></i>
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="on_leaveModal" tabindex="-1" role="dialog"
                                            aria-labelledby="on_leaveModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header" style="text-align: center;">
                                                        <h5 class="modal-title" id="on_leaveModalLongTitle">
                                                            On Leave Today
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body"
                                                        style="white-space: normal; word-wrap: break-word;">
                                                        <div>
                                                            @foreach ($on_leave as $on_leave_user)
                                                                <div class="single-leave">
                                                                    <p class="on_leave-name">
                                                                        {{ $on_leave_user->user->name }}
                                                                    </p>
                                                                    <p class="reason">{{ $on_leave_user->description }}</p>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </span>
                                </div>
                                <div class="row">
                                    <div class="col-6 col-md-12 col-xl-5">

                                        <div class="d-flex align-items-baseline">
                                            <p class="text-success">
                                            <h3 style="color:rgb(238, 164, 27);" class="mb-2 mt-4">{{ count($on_leave) }}
                                            </h3>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-12 col-xl-7">
                                        <div id="customersChart" class="mt-md-3 mt-xl-0"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-baseline">
                                    <h6 class="card-title mb-0">Absent Today</h6>
                                    <span>
                                        <!-- Button trigger modal -->
                                        <button style="background:transparent; color:crimson; border:none;" type="button"
                                            class="btn btn-sm btn-primary" data-toggle="modal"
                                            data-target="#absentModal">
                                            <i class="link-icon" data-feather="eye"></i>
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="absentModal" tabindex="-1" role="dialog"
                                            aria-labelledby="absentModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header" style="text-align: center;">
                                                        <h5 class="modal-title" id="absentModalLongTitle">
                                                            Absent Today
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body"
                                                        style="white-space: normal; word-wrap: break-word;">
                                                        <div>
                                                            @foreach ($absent_today as $absent)
                                                                <p class="absent-name">{{ $absent->name }}</p>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </span>
                                </div>
                                <div class="row">
                                    <div class="col-6 col-md-12 col-xl-5">

                                        <div class="d-flex align-items-baseline">
                                            <p class="text-success">
                                            <h3 style="color:crimson;" class="mb-2 mt-4">{{ count($absent_today) }}</h3>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-12 col-xl-7">
                                        <div id="customersChart" class="mt-md-3 mt-xl-0"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- row -->
    @else
        <div class="row">
            <div class="col-12 col-xl-12 stretch-card">
                <div class="row flex-grow-1">
                    <div class="col-md-4 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-baseline">
                                    <h6 class="card-title mb-0">Present This Month</h6>
                                    {{-- <span>
                                        <!-- Button trigger modal -->
                                        <button style="background:transparent; color:green; border:none;" type="button"
                                            class="btn btn-sm btn-primary" data-toggle="modal"
                                            data-target="#presentModal">
                                            <i class="link-icon" data-feather="eye"></i>
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="presentModal" tabindex="-1" role="dialog"
                                            aria-labelledby="presentModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header" style="text-align: center;">
                                                        <h5 class="modal-title" id="presentModalLongTitle">
                                                            Present Today
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body"
                                                        style="white-space: normal; word-wrap: break-word;">
                                                        <div>
                                                            @foreach ($present_today as $present)
                                                                <p class="present-name">{{ $present->user->name }}</p>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </span> --}}
                                </div>
                                <div class="row">
                                    <div class="col-6 col-md-12 col-xl-5">

                                        <div class="d-flex align-items-baseline">
                                            <p class="text-success">
                                            <h3 style="color:green;" class="mb-2 mt-4">{{ $present_this_month }}</h3>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-12 col-xl-7">
                                        <div id="customersChart" class="mt-md-3 mt-xl-0"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-baseline">
                                    <h6 class="card-title mb-0">Tasks This Month</h6>
                                    {{-- <span>
                                        <!-- Button trigger modal -->
                                        <button style="background:transparent; color:orange; border:none;" type="button"
                                            class="btn btn-sm btn-primary" data-toggle="modal"
                                            data-target="#on_leaveModal">
                                            <i class="link-icon" data-feather="eye"></i>
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="on_leaveModal" tabindex="-1" role="dialog"
                                            aria-labelledby="on_leaveModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header" style="text-align: center;">
                                                        <h5 class="modal-title" id="on_leaveModalLongTitle">
                                                            On Leave Today
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body"
                                                        style="white-space: normal; word-wrap: break-word;">
                                                        <div>
                                                            @foreach ($on_leave as $on_leave_user)
                                                                <p class="on_leave-name">{{ $on_leave_user->user->name }}
                                                                </p>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </span> --}}
                                </div>
                                <div class="row">
                                    <div class="col-6 col-md-12 col-xl-5">

                                        <div class="d-flex align-items-baseline">
                                            <p class="text-success">
                                            <h3 style="color:rgb(238, 164, 27);" class="mb-2 mt-4">{{ $task_this_month }}
                                            </h3>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-12 col-xl-7">
                                        <div id="customersChart" class="mt-md-3 mt-xl-0"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div> <!-- row -->
    @endif

    {{-- <div class="row">
        <div class="col-12 col-xl-12 grid-margin stretch-card">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
                        <h6 class="card-title mb-0">Revenue</h6>
                        <div class="dropdown">
                            <a type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="eye"
                                        class="icon-sm me-2"></i> <span class="">View</span></a>
                                <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                        data-feather="edit-2" class="icon-sm me-2"></i> <span class="">Edit</span></a>
                                <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                        data-feather="trash" class="icon-sm me-2"></i> <span
                                        class="">Delete</span></a>
                                <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                        data-feather="printer" class="icon-sm me-2"></i> <span
                                        class="">Print</span></a>
                                <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                        data-feather="download" class="icon-sm me-2"></i> <span
                                        class="">Download</span></a>
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-start">
                        <div class="col-md-7">
                            <p class="text-muted tx-13 mb-3 mb-md-0">Revenue is the income that a business
                                has from its normal business activities, usually from the sale of goods and
                                services to customers.</p>
                        </div>
                        <div class="col-md-5 d-flex justify-content-md-end">
                            <div class="btn-group mb-3 mb-md-0" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-outline-primary">Today</button>
                                <button type="button" class="btn btn-outline-primary d-none d-md-block">Week</button>
                                <button type="button" class="btn btn-primary">Month</button>
                                <button type="button" class="btn btn-outline-primary">Year</button>
                            </div>
                        </div>
                    </div>
                    <div id="revenueChart"></div>
                </div>
            </div>
        </div>
    </div> <!-- row --> --}}

    {{-- <div class="row">
        <div class="col-lg-7 col-xl-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline mb-2">
                        <h6 class="card-title mb-0">Monthly sales</h6>
                        <div class="dropdown mb-2">
                            <a type="button" id="dropdownMenuButton4" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton4">
                                <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                        data-feather="eye" class="icon-sm me-2"></i> <span class="">View</span></a>
                                <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                        data-feather="edit-2" class="icon-sm me-2"></i> <span
                                        class="">Edit</span></a>
                                <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                        data-feather="trash" class="icon-sm me-2"></i> <span
                                        class="">Delete</span></a>
                                <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                        data-feather="printer" class="icon-sm me-2"></i> <span
                                        class="">Print</span></a>
                                <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                        data-feather="download" class="icon-sm me-2"></i> <span
                                        class="">Download</span></a>
                            </div>
                        </div>
                    </div>
                    <p class="text-muted">Sales are activities related to selling or the number of goods or
                        services sold in a given time period.</p>
                    <div id="monthlySalesChart"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-5 col-xl-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline">
                        <h6 class="card-title mb-0">Cloud storage</h6>
                        <div class="dropdown mb-2">
                            <a type="button" id="dropdownMenuButton5" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton5">
                                <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                        data-feather="eye" class="icon-sm me-2"></i> <span class="">View</span></a>
                                <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                        data-feather="edit-2" class="icon-sm me-2"></i> <span
                                        class="">Edit</span></a>
                                <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                        data-feather="trash" class="icon-sm me-2"></i> <span
                                        class="">Delete</span></a>
                                <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                        data-feather="printer" class="icon-sm me-2"></i> <span
                                        class="">Print</span></a>
                                <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                        data-feather="download" class="icon-sm me-2"></i> <span
                                        class="">Download</span></a>
                            </div>
                        </div>
                    </div>
                    <div id="storageChart"></div>
                    <div class="row mb-3">
                        <div class="col-6 d-flex justify-content-end">
                            <div>
                                <label
                                    class="d-flex align-items-center justify-content-end tx-10 text-uppercase fw-bolder">Total
                                    storage <span class="p-1 ms-1 rounded-circle bg-secondary"></span></label>
                                <h5 class="fw-bolder mb-0 text-end">8TB</h5>
                            </div>
                        </div>
                        <div class="col-6">
                            <div>
                                <label class="d-flex align-items-center tx-10 text-uppercase fw-bolder"><span
                                        class="p-1 me-1 rounded-circle bg-primary"></span> Used
                                    storage</label>
                                <h5 class="fw-bolder mb-0">~5TB</h5>
                            </div>
                        </div>
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-primary">Upgrade storage</button>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- row --> --}}

    {{-- <div class="row">
        <div class="col-lg-5 col-xl-4 grid-margin grid-margin-xl-0 stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline mb-2">
                        <h6 class="card-title mb-0">Inbox</h6>
                        <div class="dropdown mb-2">
                            <a type="button" id="dropdownMenuButton6" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton6">
                                <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                        data-feather="eye" class="icon-sm me-2"></i> <span class="">View</span></a>
                                <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                        data-feather="edit-2" class="icon-sm me-2"></i> <span
                                        class="">Edit</span></a>
                                <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                        data-feather="trash" class="icon-sm me-2"></i> <span
                                        class="">Delete</span></a>
                                <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                        data-feather="printer" class="icon-sm me-2"></i> <span
                                        class="">Print</span></a>
                                <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                        data-feather="download" class="icon-sm me-2"></i> <span
                                        class="">Download</span></a>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-column">
                        <a href="javascript:;" class="d-flex align-items-center border-bottom pb-3">
                            <div class="me-3">
                                <img src="https://via.placeholder.com/35x35" class="rounded-circle wd-35" alt="user">
                            </div>
                            <div class="w-100">
                                <div class="d-flex justify-content-between">
                                    <h6 class="text-body mb-2">Leonardo Payne</h6>
                                    <p class="text-muted tx-12">12.30 PM</p>
                                </div>
                                <p class="text-muted tx-13">Hey! there I'm available...</p>
                            </div>
                        </a>
                        <a href="javascript:;" class="d-flex align-items-center border-bottom py-3">
                            <div class="me-3">
                                <img src="https://via.placeholder.com/35x35" class="rounded-circle wd-35" alt="user">
                            </div>
                            <div class="w-100">
                                <div class="d-flex justify-content-between">
                                    <h6 class="text-body mb-2">Carl Henson</h6>
                                    <p class="text-muted tx-12">02.14 AM</p>
                                </div>
                                <p class="text-muted tx-13">I've finished it! See you so..</p>
                            </div>
                        </a>
                        <a href="javascript:;" class="d-flex align-items-center border-bottom py-3">
                            <div class="me-3">
                                <img src="https://via.placeholder.com/35x35" class="rounded-circle wd-35" alt="user">
                            </div>
                            <div class="w-100">
                                <div class="d-flex justify-content-between">
                                    <h6 class="text-body mb-2">Jensen Combs</h6>
                                    <p class="text-muted tx-12">08.22 PM</p>
                                </div>
                                <p class="text-muted tx-13">This template is awesome!</p>
                            </div>
                        </a>
                        <a href="javascript:;" class="d-flex align-items-center border-bottom py-3">
                            <div class="me-3">
                                <img src="https://via.placeholder.com/35x35" class="rounded-circle wd-35" alt="user">
                            </div>
                            <div class="w-100">
                                <div class="d-flex justify-content-between">
                                    <h6 class="text-body mb-2">Amiah Burton</h6>
                                    <p class="text-muted tx-12">05.49 AM</p>
                                </div>
                                <p class="text-muted tx-13">Nice to meet you</p>
                            </div>
                        </a>
                        <a href="javascript:;" class="d-flex align-items-center border-bottom py-3">
                            <div class="me-3">
                                <img src="https://via.placeholder.com/35x35" class="rounded-circle wd-35" alt="user">
                            </div>
                            <div class="w-100">
                                <div class="d-flex justify-content-between">
                                    <h6 class="text-body mb-2">Yaretzi Mayo</h6>
                                    <p class="text-muted tx-12">01.19 AM</p>
                                </div>
                                <p class="text-muted tx-13">Hey! there I'm available...</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-7 col-xl-8 stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline mb-2">
                        <h6 class="card-title mb-0">Projects</h6>
                        <div class="dropdown mb-2">
                            <a type="button" id="dropdownMenuButton7" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton7">
                                <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                        data-feather="eye" class="icon-sm me-2"></i> <span class="">View</span></a>
                                <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                        data-feather="edit-2" class="icon-sm me-2"></i> <span
                                        class="">Edit</span></a>
                                <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                        data-feather="trash" class="icon-sm me-2"></i> <span
                                        class="">Delete</span></a>
                                <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                        data-feather="printer" class="icon-sm me-2"></i> <span
                                        class="">Print</span></a>
                                <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                        data-feather="download" class="icon-sm me-2"></i> <span
                                        class="">Download</span></a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th class="pt-0">#</th>
                                    <th class="pt-0">Project Name</th>
                                    <th class="pt-0">Start Date</th>
                                    <th class="pt-0">Due Date</th>
                                    <th class="pt-0">Status</th>
                                    <th class="pt-0">Assign</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>NobleUI jQuery</td>
                                    <td>01/01/2022</td>
                                    <td>26/04/2022</td>
                                    <td><span class="badge bg-danger">Released</span></td>
                                    <td>Leonardo Payne</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>NobleUI Angular</td>
                                    <td>01/01/2022</td>
                                    <td>26/04/2022</td>
                                    <td><span class="badge bg-success">Review</span></td>
                                    <td>Carl Henson</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>NobleUI ReactJs</td>
                                    <td>01/05/2022</td>
                                    <td>10/09/2022</td>
                                    <td><span class="badge bg-info">Pending</span></td>
                                    <td>Jensen Combs</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>NobleUI VueJs</td>
                                    <td>01/01/2022</td>
                                    <td>31/11/2022</td>
                                    <td><span class="badge bg-warning">Work in Progress</span>
                                    </td>
                                    <td>Amiah Burton</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>NobleUI Laravel</td>
                                    <td>01/01/2022</td>
                                    <td>31/12/2022</td>
                                    <td><span class="badge bg-danger">Coming soon</span></td>
                                    <td>Yaretzi Mayo</td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>NobleUI NodeJs</td>
                                    <td>01/01/2022</td>
                                    <td>31/12/2022</td>
                                    <td><span class="badge bg-primary">Coming soon</span></td>
                                    <td>Carl Henson</td>
                                </tr>
                                <tr>
                                    <td class="border-bottom">3</td>
                                    <td class="border-bottom">NobleUI EmberJs</td>
                                    <td class="border-bottom">01/05/2022</td>
                                    <td class="border-bottom">10/11/2022</td>
                                    <td class="border-bottom"><span class="badge bg-info">Pending</span>
                                    </td>
                                    <td class="border-bottom">Jensen Combs</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- row --> --}}
@endsection
