@extends('admin.auth.layout.login_layout')
@section('content')
    <div class="login-cover-wrapper">
        <div class="card shadow-none">
            <div class="card-body">
                <div class="text-center">
                    <h4>2FA Secret Key</h4>
                    <p>Open up your 2FA mobile app and scan the following QR barcode:</p>
                </div>
                <div class="row">
                    <div class="image-holder d-flex" style="justify-content:center">
                        {!! $image !!}
                    </div>
                    <div>
                        <div class="alert">
                            <div class="alert-info">
                                <div class="alert-message">
                                    <p class="juctify-content p-3">
                                        If your 2FA mobile app does not support QR barcodes,
                                        enter in the following number: <code>{{ $secret }}</code>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-12">

                        <div class="card shadow-none">
                            <div class="card-body">
                                <div class="text-center">
                                    <p>Enter OTP From Authrnticator App</p>
                                </div>
                                <form class="form-body row g-3" method="POST" action="{{ route('post-validate-2fa') }}">
                                    @csrf
                                    <div class="col-12">
                                        <label for="inputEmail" class="form-label">OTP</label>
                                        <input type="text"
                                            class="form-control {{ isset($errors) && $errors->has('otp') ? 'is-invalid' : '' }}"
                                            id="inputotp" name="otp">
                                        @if (isset($errors) && $errors->has('otp'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('otp') }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="col-12 col-lg-12">
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-dark">Validate</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>


                        {{-- <div class="d-grid">
                            <a href="{{ route('validate-2fa') }}" class="btn btn-dark">Validate OTP</a>
                        </div> --}}
                    </div>
                </div>




            </div>
        </div>
    </div>
@endsection
