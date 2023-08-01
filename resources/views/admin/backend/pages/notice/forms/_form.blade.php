<form class="row g-3" method="POST" action="{{ route('backend.notice-store')}}">
    <div class="row">
        @include('error')
        <div class="col-xl-10 mx-auto">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="border p-3 rounded">
                        <h6 class="mb-0 text-uppercase">Make Announcement</h6>
                        <hr>
                        @csrf
                        <div class="col-12 mb-2 ">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title" id="" class="form-control" />
                            </div>

                            <div class="form-group">
                                <label for="Description">Message</label>
                                <textarea name="description" rows="15" class="form-control editor"></textarea>
                            </div>
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

            plugins: 'readmore preview advlist link importcss searchreplace autosave save directionality code visualblocks visualchars fullscreen image media template codesample table charmap pagebreak nonbreaking anchor insertdatetime lists wordcount help charmap emoticons',

            imagetools_cors_hosts: ['picsum.photos'],
            image_caption: true,


            relative_urls: false,
            convert_urls: false,
            menubar: '',

            toolbar: 'blocks code bold italic underline link blockquote alignleft aligncenter alignjustify numlist bullist charmap  table',

            link_context_toolbar: true,

            toolbar_sticky: true,


            // file_picker_types: 'image',
            /* and here's our custom image picker*/


            // success color
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px; width: 95%; } .readmore{ border: solid 1px #ccc;background-color: #eee; font-size: 17px; font-weight:bold; border-radius:7px; width:35%; color:black; padding: 5px 10px; margin: 10px 0; }',


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
    </script>
@endpush
