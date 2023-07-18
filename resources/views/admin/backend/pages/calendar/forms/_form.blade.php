<form class="row g-3" method="POST"
    action="{{ isset($date) ? route('backend.calendar-update', $date->id) : route('backend.calendar-store') }}"
    enctype="multipart/form-data">
    <div class="row">
        @include('error')
        <div class="col-xl-10 mx-auto">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="border p-3 rounded">
                        <h6 class="mb-0 text-uppercase">{{ (isset($date) ? 'Update' : 'Create') . ' monthly calendar' }}
                        </h6>
                        <hr>
                        @csrf
                        <div class="col-12 mb-2 ">
                            <label class="form-label">Year*</label>
                            <input type="text"
                                class="form-control {{ isset($errors) && $errors->has('year') ? 'is-invalid' : '' }} mb-2"
                                name="year" value="{{ isset($date) ? $date->year : old('year') }}">
                            @if (isset($errors) && $errors->has('year'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('year') }}
                                </div>
                            @endif

                            <label for="month">Select Month*</label>
                            <select class='mb-2 form-control' name="month" id="">
                                <option value="">Select Month</option>
                                @foreach (config('constants.nepali_months') as $month)
                                    <option {{ isset($date) ? ($date->month == $month ? 'selected' : '') : '' }}
                                        value="{{ $month }}">{{ $month }}</option>
                                @endforeach
                            </select>

                            <label class="form-label">First Day*</label>
                            <input type="text"
                                class="form-control {{ isset($errors) && $errors->has('first_day') ? 'is-invalid' : '' }} mb-2"
                                name="first_day" {{ isset($date) ? $date->first_day : old('first_day') }}
                                id="first_day">
                            @if (isset($errors) && $errors->has('first_day'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('first_day') }}
                                </div>
                            @endif

                            <label class="form-label">Last Day*</label>
                            <input type="text"
                                class="form-control {{ isset($errors) && $errors->has('last_day') ? 'is-invalid' : '' }} mb-2"
                                name="last_day" value="{{ isset($date) ? $date->last_day : old('last_day') }}"
                                id="last_day">
                            @if (isset($errors) && $errors->has('last_day'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('last_day') }}
                                </div>
                            @endif

                            <label class="form-label">Public Holidays*</label>
                            <input type="text"
                                class="form-control {{ isset($errors) && $errors->has('public_holidays') ? 'is-invalid' : '' }} mb-2"
                                name="public_holidays"
                                value="{{ isset($date) ? $date->public_holidays : old('public_holidays') }}"
                                id="public_holidays">
                            @if (isset($errors) && $errors->has('public_holidays'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('public_holidays') }}
                                </div>
                            @endif
                        </div>

                        <button type="submit" class="mx-3 btn btn-success">
                            {{ isset($date) ? 'Update' : 'Save' }}
                        </button>
                    </div>

                </div>
            </div>

        </div>
    </div>
</form>
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let public_holidays = @json($date->public_holidays ?? '');

            // Split the string if public_holidays is not an empty string
            if (public_holidays !== '') {
                public_holidays = public_holidays.split(',');
            } else {
                // Handle the case when `$date->public_holidays` is not set or empty
                public_holidays = [];
            }
            const fpFirstCalendar = flatpickr("#first_day", {
                dateFormat: "Y-m-d",
                defaultDate: '{{ isset($date->first_day) ? $date->first_day : "today" }}',
                // Add more configuration options as needed
            });

            const fpSecondCalendar = flatpickr("#last_day", {
                dateFormat: "Y-m-d",
                defaultDate: '{{ isset($date->last_day) ? $date->last_day : "today" }}',
                // Add more configuration options as needed
            });
            const fpThirdCalendar = flatpickr("#public_holidays", {
                dateFormat: "Y-m-d",
                defaultDate: public_holidays,
                mode: "multiple"

                // Add more configuration options as needed
            });
            @if (isset($date))

                fpThirdCalendar.set("minDate", '{{ $date->first_day }}');
                fpThirdCalendar.set("maxDate", '{{ $date->last_day }}');
            @endif
            fpSecondCalendar.config.onClose.push(() => {
                const firstDate = fpFirstCalendar.selectedDates[0];
                const secondDate = fpSecondCalendar.selectedDates[0];
                // Set the minimum date for the second calendar to be the selected date in the first calendar
                fpThirdCalendar.set("minDate", firstDate);
                fpThirdCalendar.set("maxDate", secondDate);
            });

        });
    </script>
@endpush
