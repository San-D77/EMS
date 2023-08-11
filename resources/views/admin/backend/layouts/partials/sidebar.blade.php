<!-- partial:partials/_sidebar.html -->
<nav class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('backend.dashboard') }}" class="sidebar-brand">
            <img style="width:125px;" src="{{ asset('/assets/images/logo.png') }}" alt="">
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">

        {{-- Dynamic Start --}}
        <ul class="nav">
            @foreach (config('constants.sidebar_components') as $component)
                @if ($component['hasChildren'] == 'true' && in_array(Auth::user()->role->slug, $component['roles']))
                    <li class="nav-item">
                        <a class="nav-link" role="button">
                            <i class="link-icon" data-feather="{{ $component['icon'] }}"></i>
                            <span class="link-title">{{ ucwords($component['name']) }}
                            </span>
                            {{-- <i class="link-arrow" data-feather="chevron-down"></i> --}}
                        </a>
                        <div class="" id="">
                            <ul class="nav sub-menu">
                                @foreach ($component['children'] as $child)
                                    @if (in_array(Auth::user()->role->slug, $child['roles']))
                                        <li class="nav-item">
                                            <a href="{{ $child['parameter'] ? route($child['route'], Auth::user()->id) : route($child['route']) }}"
                                                class="nav-link {{ Route::currentRouteName() == $child['route'] ? 'active' : '' }}">{{ ucwords($child['name']) }}
                                                @if ($child['name'] == 'Notice')
                                                    <span class="{{ strtolower($child['name']) }}-counter d-none"></span>
                                                @elseif($child['name'] == 'Approvals')
                                                    <span class="leave-counter d-none"></span>
                                                @endif
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </li>
                @else
                    @if (in_array(Auth::user()->role->slug, $component['roles']))
                        <li class="nav-item {{ Route::currentRouteName() == $component['route'] ? 'active' : '' }}">
                            <a href="{{ route($component['route'], [$component['parameter']]) }}" class="nav-link">
                                <i class="link-icon" data-feather="{{ $component['icon'] }}"></i>
                                <span class="link-title">{{ ucwords($component['name']) }}</span>
                            </a>
                        </li>
                    @endif
                @endif
            @endforeach
        </ul>
        {{-- Dynamic End --}}
        {{-- <ul class="nav">
            <li class="nav-item">
                <a href="{{ route('backend.dashboard') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#users" role="button" aria-expanded="false"
                    aria-controls="users">
                    <i class="link-icon" data-feather="users"></i>
                    <span class="link-title">Users</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="users">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('backend.user-view') }}" class="nav-link">All Users</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.user-create') }}" class="nav-link">Add New</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#role" role="button" aria-expanded="false"
                    aria-controls="role">
                    <i class="link-icon" data-feather="feather"></i>
                    <span class="link-title">Role</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="role">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('backend.role-view') }}" class="nav-link">Roles</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.role-create') }}" class="nav-link">Add New</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#permission" role="button" aria-expanded="false"
                    aria-controls="permission">
                    <i class="link-icon" data-feather="layers"></i>
                    <span class="link-title">Permission</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="permission">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('backend.permission-view') }}" class="nav-link">Permissions</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.permission-create') }}" class="nav-link">Add New</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#calendar" role="button" aria-expanded="false"
                    aria-controls="calendar">
                    <i class="link-icon" data-feather="calendar"></i>
                    <span class="link-title">Calendar</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="calendar">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('backend.calendar-index') }}" class="nav-link">Dates</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.calendar-create') }}" class="nav-link">Add New</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.calendar-public_holiday_index') }}" class="nav-link">Public
                                Holidays</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a href="{{ route('backend.attendance-view', Auth::user()->id) }}" class="nav-link">
                    <i class="link-icon" data-feather="clipboard"></i>
                    <span class="link-title">Attendance</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('backend.attendance-view_reports') }}" class="nav-link">
                    <i class="link-icon" data-feather="book-open"></i>
                    <span class="link-title">Reports</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('backend.attendance-today') }}" class="nav-link">
                    <i class="link-icon" data-feather="loader"></i>
                    <span class="link-title">Today</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#leave" role="button" aria-expanded="false"
                    aria-controls="leave">
                    <i class="link-icon" data-feather="inbox"></i>
                    <span class="link-title">Leave<span class="notification-counter d-none"></span></span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="leave">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('backend.leave-index') }}" class="nav-link">Approvals<span
                                    class="notification-counter d-none"></span></a>

                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.leave-create', Auth::user()->id) }}" class="nav-link">Apply
                                for Leave</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.leave-individual', Auth::user()->id) }}" class="nav-link">Your
                                Leaves</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#notice" role="button" aria-expanded="false"
                    aria-controls="notice">
                    <i class="link-icon" data-feather="bell"></i>
                    <span class="link-title">Notice <span class="notice-counter d-none"></span></span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="notice">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('backend.notice-create') }}" class="nav-link">Make Announcement</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.notice-view') }}" class="nav-link">Notice <span
                                    class="notice-counter d-none"></span></a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul> --}}
    </div>
</nav>
