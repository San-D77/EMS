<nav class="navbar">

    <a href="#" class="sidebar-toggler">
        <i data-feather="menu"></i>
    </a>
    <div class="navbar-content">

        <form class="search-form">
            <div class="input-group">
                <div class="input-group-text">
                    <i data-feather="search"></i>
                </div>
                <input type="text" class="form-control" id="navbarForm" placeholder="Search here...">
            </div>
        </form>
        <ul class="navbar-nav">
            <li class="nav-item">
                <span style="color: green;" id="session-duration"></span>
            </li>
            @if (!$submitted)
                <li class="nav-item">
                    <a class="nav-link"
                        href="{{ isset($start_time) ? route('backend.attendance-terminate_session', Auth::user()->id) : route('backend.attendance-register_attendance', Auth::user()->id) }}"
                        role="button">
                        <i style="{{ isset($start_time) ? 'color:red;' : 'color:green;' }}"
                            data-feather="{{ isset($start_time) ? 'stop-circle' : 'play-circle' }}"></i>
                    </a>
                </li>
            @endif

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="wd-30 ht-30 rounded-circle" src="https://via.placeholder.com/30x30" alt="profile">
                </a>
                <div class="dropdown-menu p-0" aria-labelledby="profileDropdown">
                    <div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
                        <div class="mb-3">
                            <img class="wd-80 ht-80 rounded-circle" src="https://via.placeholder.com/80x80"
                                alt="">
                        </div>
                        <div class="text-center">
                            <p class="tx-16 fw-bolder">{{ Auth::user()->name }}</p>
                            <p class="tx-12 text-muted">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                    <ul class="list-unstyled p-1">
                        <li class="dropdown-item py-2">
                            <a href="{{ route('backend.user-update_profile', Auth::user()->id) }}"
                                class="text-body ms-0">
                                <i class="me-2 icon-md" data-feather="user"></i>
                                <span>Profile</span>
                            </a>
                        </li>
                        <li class="dropdown-item py-2">
                            <a href="javascript:;" class="text-body ms-0">
                                <i class="me-2 icon-md" data-feather="edit"></i>
                                <span>Edit Profile</span>
                            </a>
                        </li>
                        <li class="dropdown-item py-2">
                            <a href="javascript:;" class="text-body ms-0">
                                <i class="me-2 icon-md" data-feather="repeat"></i>
                                <span>Switch User</span>
                            </a>
                        </li>
                        <li class="dropdown-item py-2">
                            <a href="{{ route('logout') }}" class="text-body ms-0">
                                <i class="me-2 icon-md" data-feather="log-out"></i>
                                <span>Log Out</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>
<!-- partial -->
@push('scripts')
    <script>
        function calculateTimeDifference(previousTime) {
            var currentTime = new Date();
            var previousDateTime = new Date(currentTime.toDateString() + ' ' + previousTime);

            var timeDifference = Math.abs(currentTime - previousDateTime);
            var hours = Math.floor(timeDifference / 3600000); // 1 hour = 3600000 milliseconds
            var minutes = Math.floor((timeDifference % 3600000) / 60000); // 1 minute = 60000 milliseconds
            var seconds = Math.floor((timeDifference % 60000) / 1000); // 1 second = 1000 milliseconds

            return {
                hours: hours,
                minutes: minutes,
                seconds: seconds
            };
        }

        function updateTimer(previousTime) {
            var timerElement = document.getElementById('session-duration');
            var timeDifference = calculateTimeDifference(previousTime);
            var hours = timeDifference.hours.toString().padStart(2, '0');
            var minutes = timeDifference.minutes.toString().padStart(2, '0');
            var seconds = timeDifference.seconds.toString().padStart(2, '0');

            timerElement.textContent = hours + ':' + minutes + ':' + seconds;

            setInterval(function() {
                var timeDifference = calculateTimeDifference(previousTime);
                var hours = timeDifference.hours.toString().padStart(2, '0');
                var minutes = timeDifference.minutes.toString().padStart(2, '0');
                var seconds = timeDifference.seconds.toString().padStart(2, '0');

                timerElement.textContent = hours + ':' + minutes + ':' + seconds;
            }, 1000);
        }

        // Usage: Call the updateTimer function passing the previous time string (e.g., '2023-07-06 15:16:29')
        const startTime = @json($start_time);
        startTime ? updateTimer(startTime) : '';
    </script>
@endpush
