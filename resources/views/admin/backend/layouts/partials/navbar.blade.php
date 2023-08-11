<nav class="navbar">

    <a href="#" class="sidebar-toggler">
        <i data-feather="menu"></i>
    </a>
    <div class="navbar-content">

        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <h4 style="color:rgb(9, 100, 9);">{{ toBikramSambatDate(\Carbon\Carbon::today()) }}</h4>
        </div>
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
                    <img class="wd-30 ht-30 rounded-circle" src="{{ Auth::user()->avatar?asset('/avatars/thumbnail/'.Auth::user()->avatar): (Auth::user()->gender == 'female'? asset('/avatar/female-avatar.jpg') : asset('/avatar/male-avatar.jpg')) }}" style="object-fit:cover;object-position:cover;" alt="profile">
                </a>
                <div class="dropdown-menu p-0" aria-labelledby="profileDropdown">
                    <div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
                        <div class="mb-3">
                            <img class="wd-80 ht-80 rounded-circle" src="{{ Auth::user()->avatar?asset('/avatars/thumbnail/'.Auth::user()->avatar): (Auth::user()->gender == 'female'? asset('/avatar/female-avatar.jpg') : asset('/avatar/male-avatar.jpg')) }}"
                                alt="" style="object-fit:cover;object-position:cover;">
                        </div>
                        <div class="text-center">
                            <p class="tx-16 fw-bolder">{{ Auth::user()->name }}</p>
                            <p class="tx-12 text-muted">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                    <ul class="list-unstyled p-1">
                        <a href="{{ route('backend.user-update_profile', Auth::user()->id) }}" class="text-body ms-0">
                            <li class="dropdown-item py-2">
                                <i class="me-2 icon-md" data-feather="user"></i>
                                <span>Profile</span>
                            </li>
                        </a>
                        <a href="{{ route('logout') }}" class="text-body ms-0">
                            <li class="dropdown-item py-2">
                                <i class="me-2 icon-md" data-feather="log-out"></i>
                                <span>Log Out</span>
                            </li>
                        </a>
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
