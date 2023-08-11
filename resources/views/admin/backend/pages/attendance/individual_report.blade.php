@extends('admin.backend.layouts.index')
@section('content')
    @push('styles')
        <style>
            .table-striped>tbody>tr>td.less-task {
                background: #eb7777;
                padding: 10px;
                color: #494949 !important;
                --bs-table-striped-bg: #eb7777;
            }

            .table-striped>tbody>tr>td.less-time {
                background: #ebbd77;
                padding: 10px;
                color: #494949 !important;
                --bs-table-striped-bg: #ebbd77;
            }

            .single-task {
                /* border: 1px solid #ff9c9c; */
                border-radius: 5px;
                padding: 15px;
                margin-bottom: 10px;
                box-shadow: 0 4px 4px 0 rgba(0, 0, 0, 0.5);
                color: #1269da;
                font-size: 16px;
                line-height: 25px;
                font-weight: 500;
            }

            .remarks {
                color: #4f0fff;
                display: block;
                margin-top: 15px;
            }

            .title {
                display: block;
                color: green;
                margin: 10px 0px;
            }
        </style>
    @endpush
    <span style="color:#1269da; font-size: 20px; font-weight: 600;">{{ $reports[0]->user->name }}</span>
    <div style="display:flex;flex-direction:row;justify-content:end; align-items:center;">
        <span class="mx-3 task-counter" style="font-size:18px; font-weight:500; color: green;">Total Tasks:
            {{ $tasks->total }}</span>
        <a href="{{ route('backend.attendance-individual_report', [$user->id, 'last-month']) }}"
            class="btn btn-sm btn-primary ">Last Month</a>
        <a href="{{ route('backend.attendance-individual_report', [$user->id, 'this-month']) }}"
            class="btn btn-sm btn-primary mx-2">This Month</a>
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
    <table class="table table-striped" style=" ">
        <thead>
            <th>S.N.</th>
            <th>Date</th>
            <th>Day</th>
            <th>Session Start</th>
            <th>Session End</th>
            <th>Stay Time</th>
            <th>Tasks</th>
        </thead>
        <tbody class="report-data">
            @foreach ($reports as $single_report)
                <tr style="background:#b6dde9 !important; font-size: 17px; font-weight:600;">
                    <td>
                        {{ $loop->iteration }}
                    </td>
                    <td>{{ $single_report->day }}</td>
                    <td><span
                            style="background: #ffe02f; padding: 5px 10px; border-radius: 4px; font-family: Courier New, monospace;">{{ $single_report->created_at->format('D') }}</span>
                    </td>
                    <td>{{ $single_report->session_start }}</td>
                    <td>{{ $single_report->session_end }}</td>
                    <td
                        class="
                                            {{ strtotime($single_report->duration) < strtotime($single_report->user->standard_time) ? 'less-time' : '' }}
                                        ">
                        {{ $single_report->duration }}</td>
                    <td style="color:rgb(32, 7, 29);"
                        class="{{ count(json_decode($single_report->task_report)) < (int) $single_report->user->standard_task ? 'less-task' : '' }}">
                        {{ count(json_decode($single_report->task_report)) }}
                    </td>
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

                    fetch('{{ route('backend.attendance-individual_report_json', [$reports[0]->user->id]) }}', {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-Token": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                first_date: formattedFirstDate,
                                second_date: formattedSecondDate
                            })
                        }).then(response => response.json())
                        .then(data => {
                            d = data.data;

                            const tbodyField = document.querySelector(".report-data");
                            const taskCounter = document.querySelector('.task-counter');

                            if (d.length > 0) {
                                let iteration = 0;
                                htm = '';
                                d.forEach(single_report => {
                                    var dateObj = new Date(single_report['created_at']);
                                    const taskReportCount = single_report.task_report ? JSON.parse(single_report[
                                        'task_report']).length : 0;

                                    const date1 = new Date(`1970-01-01T${single_report['duration']}`);
                                    const date2 = new Date(`1970-01-01T{{ $single_report->user->standard_time }}`)

                                    const task_count = JSON.parse(single_report['task_report']).length
                                    const standard_task = {{ $single_report->user->standard_task }} <= task_count

                                    iteration++;
                                    htm += `
                                        <tr style="background:#b6dde9 !important; font-size: 17px; font-weight:600;">
                                            <td>
                                                ${iteration}
                                            </td>
                                            <td>${ single_report['day']? single_report['day'] :'' }</td>
                                            <td><span
                            style="background: #ffe02f; padding: 5px 10px; border-radius: 4px; font-family: Courier New, monospace;">${ dateObj.toLocaleString('en-US', { weekday: 'short' }) }</span></td>
                                            <td>${ single_report['session_start']? single_report['session_start'] :'' }</td>
                                            <td>${ single_report['session_end']? single_report['session_end'] :'' }</td>
                                            <td class="${(date1  < date2)? 'less-time' : ''}">${ single_report['duration']? single_report['duration'] :'' }</td>
                                            <td class="${standard_task ? '' : 'less-task'}">${taskReportCount}</td>
                                        </tr>`
                                });
                                tbodyField.innerHTML = htm;
                                taskCounter.innerText = "Total Tasks: " + data.tasks.total;
                            } else {
                                htm = "There is no record for the duration you selected!"
                                tbodyField.innerHTML = htm;
                                taskCounter.innerText = "Total Tasks: " + 0;
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
