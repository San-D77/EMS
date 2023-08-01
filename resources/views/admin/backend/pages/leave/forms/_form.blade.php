<form class="row g-3" method="POST" action="">
    <div class="row">
        @include('error')
        <div class="col-xl-10 mx-auto">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="border p-3 rounded">
                        <h6 class="mb-0 text-uppercase">lEAVE FORM</h6>
                        <hr>
                        @csrf
                        <div class="col-12 mb-2 ">
                            <div class="m-3">
                                <input type="radio" name="leave-type" checked id="" value="one-day"
                                    onchange="handleLeaveTypeChange(this)"> One Day
                                <input type="radio" name="leave-type" id="" value="multi-day"
                                    onchange="handleLeaveTypeChange(this)"> Multi Day
                            </div>
                            <div class="row multi-day d-none">
                                <div class="col-md-6">
                                    <label class="form-label">From*</label>
                                    <input type="text"
                                        class="form-control {{ isset($errors) && $errors->has('first_day') ? 'is-invalid' : '' }} mb-2"
                                        name="first_day" {{ isset($date) ? $date->first_day : old('first_day') }}
                                        id="first_day">
                                    @if (isset($errors) && $errors->has('first_day'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('first_day') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">To*</label>
                                    <input type="text"
                                        class="form-control {{ isset($errors) && $errors->has('last_day') ? 'is-invalid' : '' }} mb-2"
                                        name="last_day" value="{{ isset($date) ? $date->last_day : old('last_day') }}"
                                        id="last_day">
                                    @if (isset($errors) && $errors->has('last_day'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('last_day') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="one-day">
                                <label class="form-label">Select Date*</label>
                                <input type="text"
                                    class="form-control {{ isset($errors) && $errors->has('first_day') ? 'is-invalid' : '' }} mb-2"
                                    name="date" {{ isset($date) ? $date->first_day : old('first_day') }}
                                    id="one_day">
                                @if (isset($errors) && $errors->has('first_day'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('first_day') }}
                                    </div>
                                @endif
                            </div>
                            <label for="Description">Description</label>
                            <textarea name="description" id="" rows="5" class="form-control"></textarea>
                        </div>


                        <button type="submit" class="btn btn-success mx-3">
                            {{ isset($permission) ? 'Update' : 'Send' }}
                        </button>
                    </div>

                </div>
            </div>

        </div>
    </div>
</form>
@push('scripts')
    <script>
        const single = document.querySelector('.one-day');
        const multi = document.querySelector('.multi-day');

        function handleLeaveTypeChange(radio) {
            const selectedLeaveType = radio.value;

            single.classList.toggle('d-none');
            multi.classList.toggle('d-none');

        }
        const fpFirstCalendar = flatpickr("#first_day", {
            dateFormat: "Y-m-d",
            defaultDate: '{{ isset($date->first_day) ? $date->first_day : 'today' }}',
            minDate: "today"
            // Add more configuration options as needed
        });

        flatpickr("#one_day", {
            dateFormat: "Y-m-d",
            defaultDate: '{{ isset($date->first_day) ? $date->first_day : 'today' }}',
            minDate: "today"
            // Add more configuration options as needed
        });

        const fpSecondCalendar = flatpickr("#last_day", {
            dateFormat: "Y-m-d",
            defaultDate: '{{ isset($date->last_day) ? $date->last_day : 'today' }}',
            minDate: "today"
            // Add more configuration options as needed
        });

        if (fpFirstCalendar) {
            fpFirstCalendar.config.onClose.push(() => {
                const firstDate = fpFirstCalendar.selectedDates[0];
                const minDate = new Date(firstDate.getTime() + 24 * 60 * 60 * 1000);
                // Set the minimum date for the second calendar to be the selected date in the first calendar
                fpSecondCalendar.set("minDate", minDate);

            });

        }

    </script>
@endpush
