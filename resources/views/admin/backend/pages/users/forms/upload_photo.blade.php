<form action="{{ route('backend.user-post_upload_photo') }}" method="post" enctype="multipart/form-data">
    @csrf
    @include('error')
        <div class="col-6 mb-2 ">

            <label class="form-label">Avatar</label>

            <input type="file" name="avatar" class="form-control"
                onchange="document.getElementById('preview-image').src = window.URL.createObjectURL(this.files[0])">

            @isset($user)
                <div style="margin: 0 auto;">
                    <img style="width:205px; height:205px; margin-top:15px; object-fit: cover;
                object-position: top; border-radius:100%;"
                        src="{{ asset($user->avatar) }}" alt="">
                </div>
            @endisset

            <div class="row">
                <div class="col-6 mt-3">
                    <img height="150" width="300" id="preview-image" src="#" class="img-fluid" alt="">
                </div>
            </div>
        </div>
        <input type="submit" value="Upload" class="btn btn-success btn-sm mx-3">
    </form>
