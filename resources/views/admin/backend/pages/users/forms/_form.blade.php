@push('styles')
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice__display {
            padding-left: 15px !important;
        }
    </style>
@endpush
<form class="row g-3" method="POST" protected $casts=[ ];
    action="{{ isset($user) ? route('backend.user-update', ['user' => $user]) : route('backend.user-store') }}"
    enctype="multipart/form-data">
    <div class="row">
        @include('error')
        <div class="col-xl-10 mx-auto">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="border p-3 rounded">
                        <h6 class="mb-0 text-uppercase">{{ (isset($user) ? 'Update' : 'Create') . ' User' }}</h6>
                        <hr>
                        @csrf
                        <div class="col-12 mb-2 ">
                            <label class="form-label">Full Name *</label>
                            <input type="text"
                                class="form-control {{ isset($errors) && $errors->has('name') ? 'is-invalid' : '' }}"
                                name="name" value="{{ isset($user) ? $user->name : old('name') }}">
                            @if (isset($errors) && $errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                        </div>


                        <div class="col-12 mb-2 ">
                            <label class="form-label">Email *</label>
                            <input type="text"
                                class="form-control {{ isset($errors) && $errors->has('email') ? 'is-invalid' : '' }}"
                                name="email" value="{{ isset($user) ? $user->email : old('email') }}">
                            @if (isset($errors) && $errors->has('email'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                        </div>

                        <div class="col-12 mb-2 ">
                            <label class="form-label">Phone Number *</label>

                            <input type="text"
                                class="form-control {{ isset($errors) && $errors->has('phone_number') ? 'is-invalid' : '' }}"
                                name="phone_number" value="{{ isset($user) ? $user->phone_number : old('phone_number') }}">
                            @if (isset($errors) && $errors->has('phone_number'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('phone_number') }}
                                </div>
                            @endif
                        </div>

                        <div class="col-12 mb-2 ">
                            <label class="form-label">Password *</label>
                            <input type="text"
                                class="form-control {{ isset($errors) && $errors->has('password') ? 'is-invalid' : '' }}"
                                name="password" value="">
                            @if (isset($errors) && $errors->has('password'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                        </div>

                        <div class="col-12 mb-2 ">
                            <label class="form-label">Alias Name *</label>
                            <input type="text"
                                class="form-control {{ isset($errors) && $errors->has('alias_name') ? 'is-invalid' : '' }}"
                                name="alias_name" value="{{ isset($user) ? $user->alias_name : old('alias_name') }}">
                            @if (isset($errors) && $errors->has('alias_name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('alias_name') }}
                                </div>
                            @endif
                        </div>

                        <div class="col-12 mb-2 ">
                            <label class="form-label">Role *</label>
                            <select name="role_id" id="role-select" class="form-control">
                                <option value="">Select Role</option>
                                @foreach ($roles as $role)
                                    <option {{ isset($user) && $user->role_id == $role->id ? 'selected' : '' }}
                                        value="{{ $role->id }}">{{ $role->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 mb-2 ">
                            <label class="form-label">Gender *</label>
                            <select name="gender" id="" class="form-control">
                                <option  value="">Select Gender</option>
                                <option {{ isset($user) && $user->gender == 'male' ? 'selected' : '' }} value="male">Male</option>
                                <option {{ isset($user) && $user->gender == 'female' ? 'selected' : '' }} value="female">Female</option>
                                <option {{ isset($user) && $user->gender == 'others' ? 'selected' : '' }} value="others">Others</option>
                            </select>
                            @if (isset($errors) && $errors->has('gender'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('gender') }}
                                </div>
                            @endif
                        </div>

                        <div class="col-12 mb-2 ">

                            <label class="form-label">Permission *</label>

                            <select class="form-control permission-select" id="permission-select" multiple="multiple"
                                name="permissions[]">
                                @foreach ($permissions as $permission)
                                    <option
                                        {{ isset($selectedPermissions) ? (in_array($permission->id, $selectedPermissions) ? 'selected' : '') : '' }}
                                        value="{{ $permission->id }}">{{ $permission->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 mb-2 ">
                            <label class="form-label">Designation*</label>
                            <select name="designation" class="form-control">
                                <option value="">Select Designation</option>
                                @foreach (config('constants.designations') as $designation)
                                    <option
                                        {{ isset($user) && $user->designation == $designation ? 'selected' : '' }}
                                        value="{{ $designation }}">{{ ucwords(str_replace('-', ' ', $designation)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 mb-2 ">
                            <label class="form-label">Employment Type*</label>
                            <select name="employment_type" class="form-control">
                                <option value="">Select Employment Type</option>
                                @foreach (config('constants.employment_types') as $type)
                                    <option {{ isset($user) && $user->employment_type == $type ? 'selected' : '' }}
                                        value="{{ $type }}">{{ ucwords(str_replace('-', ' ', $type)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <div class="col-12 mb-2 ">

                            <label class="form-label">Avatar</label>

                            <input type="file" name="avatar" class="form-control">

                            @isset($user)
                                <div style="margin: 0 auto;">
                                    <img style="width:205px; height:205px; margin-top:15px; object-fit: cover;
                                    object-position: top; border-radius:100%;"
                                        src="{{ asset($user->avatar) }}" alt="">
                                </div>
                            @endisset
                        </div> --}}


                        <button type="submit" class="btn btn-success mx-3">
                            {{ isset($user) ? 'Update' : 'Save' }}
                        </button>
                    </div>

                </div>
            </div>

        </div>
    </div>
</form>

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#permission-select').select2({
                placeholder: 'Select Permission',
            });
        });
    </script>
@endpush
