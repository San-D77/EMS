@section('styles')
    <link rel="stylesheet" href="{{ asset('backend') }}/assets/plugins/notifications/css/lobibox.min.css" />
@endsection

@push('scripts')
    <script src="{{ asset('backend') }}/assets/plugins/notifications/js/lobibox.min.js"></script>
    <script src="{{ asset('backend') }}/assets/plugins/notifications/js/notifications.min.js"></script>

    <script>
        function round_success_noti(type = "warning", message = "Something went wrong! Please try again later.") {
            var icon;
            switch (type) {
                case 'success':
                    icon = 'bx bx-check-circle';
                    break;
                case 'info':
                    icon = 'bx bx-info-circle';
                    break;
                case 'warning':
                    icon = 'bx bx-error';
                    break;
                case 'error':
                    icon = 'bx bx-x-circle';
                    break;
            }
            Lobibox.notify(type, {
                pauseDelayOnHover: true,
                size: 'mini',
                rounded: true,
                icon: icon,
                delayIndicator: false,
                continueDelayOnInactiveTab: false,
                position: 'top right',
                msg: message,
            });
        }

        @if (session()->has('success'))
            round_success_noti('success', "{{ session()->get('success') }}");
        @elseif(session()->has('info'))
            round_success_noti('info', "{{ session()->get('info') }}");
        @elseif(session()->has('warning'))
            round_success_noti('warning', "{{ session()->get('warning') }}");
        @elseif(session()->has('error'))
            round_success_noti('error', "{{ session()->get('error') }}");
        @else

        @endif
        // round_success_noti();
    </script>
@endpush
