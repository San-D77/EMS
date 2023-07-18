<form class="row g-3" method="POST"
    action="{{ isset($permission) ? route('backend.permission-update', ['permission' => $permission]) : route('backend.permission-store') }}"
    enctype="multipart/form-data">
    <div class="row">
        @include('error')
        <div class="col-xl-10 mx-auto">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="border p-3 rounded">
                        <h6 class="mb-0 text-uppercase">{{ (isset($permission) ? 'Update' : 'Create') . ' Permission' }}</h6>
                        <hr>
                        @csrf
                        <div class="col-12 mb-2 ">
                            <label class="form-label">Title*</label>
                            <input type="text"
                                class="form-control {{ isset($errors) && $errors->has('title') ? 'is-invalid' : '' }}"
                                name="title" value="{{ isset($permission) ? $permission->title : old('title') }}">
                            @if (isset($errors) && $errors->has('title'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('title') }}
                                </div>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-success btn-block">
                            {{ isset($permission) ? 'Update' : 'Save' }}
                        </button>
                    </div>

                </div>
            </div>

        </div>
    </div>
</form>

