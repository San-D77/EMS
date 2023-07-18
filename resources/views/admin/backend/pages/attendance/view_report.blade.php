@extends('admin.backend.layouts.index')
@section('content')
    <div style="display:flex;flex-direction:row;justify-content:end; align-items:center;">
        <div class="input-group flatpickr wd-200 me-2 mb-2 mb-md-0" id="first-calendar">
            <span class="input-group-text input-group-addon bg-transparent border-primary" data-toggle><i
                    data-feather="calendar" class="text-primary"></i></span>
            <input id="date1" name="date1" type="text" class="form-control bg-transparent border-primary"
                placeholder="Select date" data-input>
        </div> &nbsp;-&nbsp;&nbsp;&nbsp;
        <div class="input-group flatpickr wd-200 me-2 mb-2 mb-md-0" id="second-calendar">
            <span class="input-group-text input-group-addon bg-transparent border-primary" data-toggle><i
                    data-feather="calendar" class="text-primary"></i></span>
            <input id="date2" name="date2" type="text" class="form-control bg-transparent border-primary"
                placeholder="Select date" data-input>
        </div>

    </div>

    <table class="table table-striped">
        <thead>
            <th>S.N.</th>
            <th>Date</th>
            <th>Session Started</th>
            <th>Session Terminated</th>
            <th>Time Stayed</th>
        </thead>
        <tbody class="report-data">
            @foreach ($user_attendance as $single_attendance)
                <tr>
                    <td>
                        {{ $loop->iteration }}
                    </td>
                    <td>{{ $single_attendance->day }}</td>
                    <td>{{ $single_attendance->session_start }}</td>
                    <td>{{ $single_attendance->session_end }}</td>
                    <td>{{ $single_attendance->duration }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @push('scripts')
        <script>
            // Initialize the flatpickr calendars
            const fpFirstCalendar = flatpickr('#first-calendar', {
                wrap: true,
                dateFormat: "d-M-Y",
                defaultDate: "today",
                maxDate: "today"
            });

            const fpSecondCalendar = flatpickr('#second-calendar', {
                wrap: true,
                dateFormat: "d-M-Y",
                defaultDate: "today",
                maxDate: "today"

            });

            // Add event listeners to the calendars' "onClose" event
            fpFirstCalendar.config.onClose.push(() => {
                const selectedDate = fpFirstCalendar.selectedDates[0];

                // Set the minimum date for the second calendar to be the selected date in the first calendar
                fpSecondCalendar.set("minDate", selectedDate);
            });

            fpSecondCalendar.config.onClose.push(() => {
                fetchData();
            });

            // Function to fetch the report data based on the selected dates
            function fetchData() {
                // Get the selected dates from both calendars
                const firstDate = fpFirstCalendar.selectedDates[0];
                const secondDate = fpSecondCalendar.selectedDates[0];

                // Check if both dates are selected
                if (firstDate && secondDate) {
                    // Convert the dates to a desired format for the API call
                    const formattedFirstDate = formatDate(firstDate);
                    const formattedSecondDate = formatDate(secondDate);



                    // Make the API call with the selected dates

                    fetch('{{ route('backend.attendance-generate_report', Auth::user()->id) }}', {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-Token": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                start_date: formattedFirstDate,
                                end_date: formattedSecondDate
                            })
                        }).then(response => response.json())
                        .then(data => {
                            d = data.data;

                            const tbodyField = document.querySelector(".report-data");
                            if (d.length > 0) {
                                let iteration = 0;
                                htm = '';
                                d.forEach(single_attendance => {
                                    iteration++;
                                    htm += `
                                        <tr>
                                            <td>
                                                ${iteration}
                                            </td>
                                            <td>${ single_attendance['day']? single_attendance['day'] :'' }</td>
                                            <td>${ single_attendance['session_start']? single_attendance['session_start'] :'' }</td>
                                            <td>${ single_attendance['session_end']? single_attendance['session_end'] :'' }</td>
                                            <td>${ single_attendance['duration']? single_attendance['duration'] :'' }</td>
                                        </tr>
                                    `
                                });
                                tbodyField.innerHTML = htm;
                            }else{
                                htm = "There is no record for the duration you selected!"
                                tbodyField.innerHTML = htm;
                            }
                        })
                        .catch(error => {
                            // Handle any errors that occur during the API call
                            console.error(error);
                        });
                }
            }

            function formatDateString(dateString) {
                const date = new Date(dateString);
                const options = {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                };
                const formattedDate = date.toLocaleDateString('en-US', options);
                return formattedDate;
            }

            // Function to format the date as needed for the API call
            function formatDate(date) {
                // Customize the formatting based on your API requirements
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            }
        </script>
    @endpush
@endsection
