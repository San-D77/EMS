<form class="row g-3" method="POST" action="{{ route('backend.leave-store', Auth::user()->id) }}">
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
                            <textarea name="description" class="form-control editor"></textarea>
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
<script src="https://cdn.tiny.cloud/1/xbw872gf05l003xyag73l4fuxlcse5ggqre8dxhqd72fmil6/tinymce/6/tinymce.min.js"
referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea.editor',

            plugins: 'readmore preview advlist link importcss searchreplace autosave save directionality code visualblocks visualchars fullscreen image media template codesample table charmap pagebreak nonbreaking anchor insertdatetime lists wordcount help charmap emoticons ',

            imagetools_cors_hosts: ['picsum.photos'],
            image_caption: true,


            relative_urls: false,
            convert_urls: false,
            menubar: '',

            toolbar: 'blocks code bold italic underline link blockquote alignleft aligncenter alignjustify numlist bullist charmap table ',

            link_context_toolbar: true,

            toolbar_sticky: true,


            // file_picker_types: 'image',
            /* and here's our custom image picker*/


            // success color
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px; width: 95%; } .readmore{ border: solid 1 px #ccc;background - color: #eee;font - size: 17 px;font - weight: bold;border-radius: 7 px;width: 35 % ;color: black;padding: 5 px 10 px;margin: 10 px 0; }',


        importcss_append: true,

        template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
        template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
        height: 700,
        image_caption: true,
        quickbars_selection_toolbar: '',
        noneditable_noneditable_class: "mceNonEditable",
        toolbar_mode: 'sliding',
        contextmenu: "table",

        });
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
