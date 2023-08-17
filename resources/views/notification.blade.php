<style>
    .notification-holder {
        position: fixed;
        right: -10px;
        z-index: 10000;
        font-size: 20px;
        font-weight: 600;
    }

    .success {
        background: #43c443;
        padding: 15px 55px;
        border-radius: 5px;
        color: #ffffff;
    }

    .error {
        background: #d16331;
        padding: 15px 55px;
        border-radius: 5px;
        color: #ffffff;
    }
</style>

<div class="notification-holder">

</div>

@push('scripts')
    <script>
        let notificationHolder = document.querySelector('.notification-holder');

        function round_success_noti(type, message) {
            var cla;
            var htm = '';
            switch (type) {
                case 'success':
                    cla = 'success';
                    break;
                case 'info':
                    cla = 'info';
                    break;
                case 'warning':
                    cla = 'warning';
                    break;
                case 'error':
                    cla = 'error';
                    break;
            }
            htm += `<span class="${cla}">${message}</span>`
            notificationHolder.innerHTML = htm;
            setTimeout(function() {
                htm = ''
                notificationHolder.innerHTML = htm;
            }, 5000);
        }

        @if (session()->has('success'))
            round_success_noti('success', "{{ session()->get('success') }}");
        @elseif (session()->has('info'))
            round_success_noti('info', "{{ session()->get('info') }}");
        @elseif (session()->has('warning'))
            round_success_noti('warning', "{{ session()->get('warning') }}");
        @elseif (session()->has('error'))
            round_success_noti('error', "{{ session()->get('error') }}");
        @else
        @endif
        // round_success_noti();
    </script>
@endpush
