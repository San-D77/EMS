@push('styles')
    <style>
        .single-task{
            border: 1px solid rgb(210, 210, 219);
            margin-top: 10px;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0px 0px 5px rgba(0,0,0,0.3);
        }
        .cross-btn{
            border: none;
            background: transparent;
            font-size: 19px;
            color: red;
            position: absolute;
            right: 30px;
        }
    </style>
@endpush
<div class="row">
    @include('error')
    @if($alreadySubmitted)
        <h4>Report Already Submitted</h4>
    @else
        <div class="col-xl-10 mx-auto">
            <div class="card mb-2">
                <div class="card-body">
                    <div id="taskForm" class="border p-3 rounded">
                        <h6 class="mb-0 text-uppercase"></h6>
                        Submit Your Task
                        <hr>
                        <div class="add-more-button" style="display:flex; justify-content: end;">
                            <button type="button" class="btn-sm btn-success add-more">Add+</button>
                        </div>
                        <div class="task-fields col-12 mb-2 ">
                            <div class="single-task">
                                <label class="form-label mb-2">Task Title</label>
                                <input type="text" class="task-title form-control mb-2" name="title">
                                <label for=""> Remarks</label>
                                <textarea id="" class="form-control remarks" rows="3"></textarea>
                            </div>
                        </div>
                        <button type="submit" class="submit-btn btn btn-success mx-3">
                            Submit
                        </button>
                    </div>

                </div>
            </div>

        </div>
    @endif
</div>
@push('scripts')
    <script>
        const taskDiv = document.querySelector('.task-fields');
        const addMoreBtn = document.querySelector('.add-more');

        let htmlContent = `<div class="single-task">
                        <button class="cross-btn" >X</button>
                        <label class="form-label mb-2">Task Title</label>
                        <input type="text" class="task-title form-control mb-2" name="title">
                        <label for=""> Remarks</label>
                        <textarea id="" class="form-control remarks" rows="3"></textarea>
                    </div>`;
        function validate(){
            let allTasks = document.querySelectorAll('.task-fields .single-task input');
            let count = 0;
            allTasks.forEach(task => {
                if(task.value.trim() == ''){
                    count++;
                }
            });
            return count;
        }
        addMoreBtn.addEventListener('click', function(){
            const count = validate();
            if(count == 0){
                const errorSpan = document.querySelector('#errorContent');
                errorSpan? errorSpan.remove():'';
                taskDiv.insertAdjacentHTML("beforeend", htmlContent);
            }
            else{
                const errorSpan = document.querySelector('#errorContent');
                let errorContent = `<span id="errorContent" style="margin-top:10px;color:red;" >Fill all the input fields before adding another**</span>`;
                errorSpan? '': taskDiv.insertAdjacentHTML("beforeend", errorContent);
            }
        })

        $(document).ready(function() {
            // Event delegation for cross button inside the tasks container
            $('.task-fields').on('click', '.cross-btn', function() {
                $(this).closest('.single-task').remove();
            });
        });


        document.querySelector('.submit-btn').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent form submission
            const count = validate();
            if(count == 0){
                const errorSpan = document.querySelector('#errorContent');
                errorSpan? errorSpan.remove():'';
                const tasks = [];
                const taskTitles = document.getElementsByClassName('task-title');
                const taskRemarks = document.getElementsByClassName('remarks');

                for (let i = 0; i < taskTitles.length; i++) {
                    const title = taskTitles[i].value;
                    const remarks = taskRemarks[i].value;
                    tasks.push({ title: title, remarks: remarks });
                }

                const formData = { tasks: tasks };
                const jsonData = JSON.stringify(formData);

                // Send the JSON data to the server
                // Replace the URL with your server endpoint
                fetch('{{route('backend.attendance-save_tasks',Auth::user()->id) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    },
                    body: jsonData
                }).then(response => response.json())
                .then(response => {

                    if(response.result == 'successful'){
                        window.location.href = "{{ route('backend.dashboard') }}";
                    }

                })
                .catch(error => {
                    // Handle error
                    console.error(error);
                });
            }else{
                const errorSpan = document.querySelector('#errorContent');
                let errorContent = `<span id="errorContent" style="margin-top:10px;color:red;" >Fill all the input fields before submitting**</span>`;
                errorSpan? '': taskDiv.insertAdjacentHTML("beforeend", errorContent);
            }
        });

    </script>
@endpush
