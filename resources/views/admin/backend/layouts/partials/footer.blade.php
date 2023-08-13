<!-- partial:partials/_footer.html -->
<footer
    class="footer d-flex flex-column flex-md-row align-items-center justify-content-between px-4 py-3 border-top small">
    <p class="text-muted mb-1 mb-md-0">Copyright © {{ \Carbon\Carbon::today()->format('Y') }} <a href="{{ route('backend.dashboard') }}" >Pandora</a>.</p>

</footer>
<!-- partial -->

</div>
</div>

<!-- core:js -->
<script src="{{ asset('/assets/vendors/core/core.js') }}"></script>
<!-- endinject -->

<!-- Plugin js for this page -->
<script src="{{ asset('/assets/vendors/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ asset('/assets/vendors/apexcharts/apexcharts.min.js') }}"></script>
<!-- End plugin js for this page -->

<!-- inject:js -->
<script src="{{ asset('/assets/vendors/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('/assets/js/template.js') }}"></script>
<!-- endinject -->

<!-- Custom js for this page -->
<script src="{{ asset('/assets/js/dashboard-dark.js') }}"></script>
<!-- End custom js for this page -->

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@stack('scripts')
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>
    const leave_counter = document.querySelectorAll('.leave-counter');
    const notice_counter = document.querySelectorAll('.notice-counter');
    if ("{{ $pending_leave_count }}" > 0) {
        leave_counter.forEach(single => {
            single.classList.remove('d-none');
            single.innerHTML = "{{ $pending_leave_count }}";
        });
    }


    const pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
        cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
        encrypted: true
    });
    const channel = pusher.subscribe('notification-channel');

    channel.bind('new-leave-request', function(data) {
        setTimeout(() => {
            leave_counter.forEach(single => {
                single.classList.remove('d-none');
                single.innerHTML = single.textContent != "" ? (parseInt(single.textContent) +
                    1) : "{{ $pending_leave_count + 1 }}";
            });
        }, 1000);
    });
    console.log({{ $pending_notice_count }})
    if ("{{ $pending_notice_count }}" > 0) {
        notice_counter.forEach(single => {
            single.classList.remove('d-none');
            single.innerHTML = "{{ $pending_notice_count }}";
        });
    }
    channel.bind('new-announcement', function(data) {
        setTimeout(() => {
            notice_counter.forEach(single => {
                single.classList.remove('d-none');
                single.innerHTML = single.textContent != "" ? (parseInt(single.textContent) +
                    1) : "{{ $pending_notice_count + 1 }}";
            });
        }, 1000);
    })
</script>
</body>

</html>
