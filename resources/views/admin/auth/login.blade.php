@extends('admin.auth.layout.login_layout')


@section('content')
    <div class="login-cover-wrapper">
        <div class="card shadow-none">
            <div class="card-body">
                <div class="text-center">
                    <h4>Sign In</h4>
                    <p>Sign In to your account</p>
                </div>
                <form class="form-body row g-3" method="POST" action="{{ route('post-login') }}">
                    @csrf
                    <div class="col-12">
                        <label for="inputEmail" class="form-label">Email</label>
                        <input type="email"
                            class="form-control {{ isset($errors) && $errors->has('email') ? 'is-invalid' : '' }}"
                            id="inputEmail" name="email">
                        @if (isset($errors) && $errors->has('email'))
                            <div class="invalid-feedback">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                    </div>
                    <div class="col-12">
                        <label for="inputPassword" class="form-label">Password</label>
                        <input type="password"
                            class="form-control  {{ isset($errors) && $errors->has('password') ? 'is-invalid' : '' }}"
                            id="inputPassword" name="password">

                        @if (isset($errors) && $errors->has('password'))
                            <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckRemember"
                                name="remember" value="true">
                            <label class="form-check-label" for="flexSwitchCheckRemember">Remember
                                Me</label>
                            @if (isset($errors) && $errors->has('password'))
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-12 col-lg-12">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-dark">Sign In</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
