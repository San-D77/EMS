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
    <div style="display:flex;flex-direction:row;justify-content:end; align-items:center;">

        <span class="mx-3 task-counter" style="font-size:18px; font-weight:500; color: green;">Total Tasks:
            {{ $tasks->total }}</span>
        <a href="{{ route('backend.attendance-view', ['last-month']) }}" class="btn btn-sm btn-primary ">Last Month</a>
        <a href="{{ route('backend.attendance-view', ['this-month']) }}" class="btn btn-sm btn-primary mx-2">This Month</a>
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
            <th>Day</th>
            <th>Session Started</th>
            <th>Session Terminated</th>
            <th>Time Stayed</th>
            <th>Tasks</th>
            <th>Action</th>
        </thead>
        <tbody class="report-data">
            @if ($user_attendance)
                @foreach ($user_attendance as $single_report)
                    <tr>
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
                            class="{{ $single_report->task_report ? (count(json_decode($single_report->task_report)) < (int) $single_report->user->standard_task ? 'less-task' : '') : '' }}">
                            {{ $single_report->task_report ? count(json_decode($single_report->task_report)) : '' }}
                        </td>
                        <td>
                            @if ($single_report->task_report)
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                    data-target="#viewReportModal{{ $loop->iteration }}">
                                    view
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="viewReportModal{{ $loop->iteration }}" tabindex="-1"
                                    role="dialog" aria-labelledby="viewReportModal{{ $loop->iteration }}CenterTitle"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header" style="text-align: center;">
                                                <h5 class="modal-title"
                                                    id="viewReportModal{{ $loop->iteration }}LongTitle">
                                                    Your Tasks
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body" style="white-space: normal; word-wrap: break-word;">
                                                <div>
                                                    @if ($single_report->task_report)
                                                        @foreach (json_decode($single_report->task_report) as $task)
                                                            <div class="single-task">
                                                                <span
                                                                    class="title">Title:</span><span>{{ $task->title }}</span>
                                                                @if (isset($task->remarks))
                                                                    <span class="title">Remarks:</span><span
                                                                        class="remarks">
                                                                        {{ $task->remarks }}</span>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
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

                    fetch('{{ route('backend.attendance-individual_report_json', [Auth::user()->id]) }}', {
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
                                    let task_deficit = ''
                                    let time_deficit = ''
                                    const taskReportCount = single_report.task_report ? JSON.parse(single_report
                                        .task_report).length : 0;

                                    const date1 = new Date(`1970-01-01T${single_report['duration']}`);
                                    const standard_time =
                                        "{{ isset($single_report->user->standard_time) ? $single_report->user->standard_time : 'null' }}"
                                    if (standard_time) {
                                        const date2 = new Date(
                                            `1970-01-01T{{ isset($single_report) ? $single_report->user->standard_time:'' }}`)
                                        time_deficit = date1 < date2
                                    }

                                    const task_count = JSON.parse(single_report['task_report']).length

                                    const standard_task =
                                        "{{ isset($single_report->user->standard_task) ? $single_report->user->standard_task : 'null' }}"
                                    if (standard_task) {
                                        task_deficit = task_count <= standard_task

                                    }

                                    iteration++;
                                    htm += `
                                    <tr>
                                        <td>
                                            ${iteration}
                                        </td>
                                        <td>${ single_report['day']? single_report['day'] :'' }</td>
                                        <td><span
                                            style="background: #ffe02f; padding: 5px 10px; border-radius: 4px; font-family: Courier New, monospace;">${ dateObj.toLocaleString('en-US', { weekday: 'short' }) }</span></td>
                                        <td>${ single_report['session_start']? single_report['session_start'] :'' }</td>
                                        <td>${ single_report['session_end']? single_report['session_end'] :'' }</td>
                                        <td class="${time_deficit? 'less-time' : ''}">${ single_report['duration']? single_report['duration'] :'' }</td>
                                        <td class="${task_deficit ? 'less-task' : ''}">${taskReportCount}</td>
                                        <td>`
                                    if (single_report['task_report']) {

                                        htm += `<button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                                    data-target="#viewReportModal${iteration}">
                                                    view
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="viewReportModal${iteration}" tabindex="-1"
                                                    role="dialog" aria-labelledby="viewReportModal${iteration}CenterTitle"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header" style="text-align: center;">
                                                                <h5 class="modal-title" id="viewReportModal${iteration}LongTitle">
                                                                    Your Tasks
                                                                </h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body" style="white-space: normal; word-wrap: break-word;">
                                                                <div>`
                                        if (JSON.parse(single_report['task_report']).length > 0) {
                                            JSON.parse(single_report['task_report']).forEach(task => {

                                                htm +=
                                                    `<div class="single-task">
                                                                                <span
                                                                                    class="title">Title:</span><span>${task['title']}</span>`
                                                if (task['remarks']) {
                                                    htm += ` <span class="title">Remarks:</span><span class="remarks">
                                                                                        ${task['remarks']} </span>`
                                                }
                                                htm += `</div>`
                                            })
                                        }
                                        htm += `</div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>`
                                    }
                                    htm += `</td>
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
