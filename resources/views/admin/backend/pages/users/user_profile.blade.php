@extends('admin.backend.layouts.index')
@section('content')
    @push('styles')
        <style>
            /* CSS for the profile page */
            body {
                font-family: Arial, sans-serif;
                background-color: #f7f7f7;
                margin: 0;
                padding: 0;
            }

            .profile-container {
                max-width: 600px;
                margin: 50px auto;
                background-color: #ffffff;
                padding: 30px;
                border-radius: 10px;
                box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
            }

            .avatar img {
                width: 200px;
                height: 200px;
                border-radius: 50%;
                margin-bottom: 20px;
                object-fit: cover;
                object-position: top;
            }

            h2 {
                font-size: 32px;
                margin-bottom: 20px;
                color: #333333;
            }

            .profile-info {
                display: flex;
                flex-direction: column;
                margin-top: 20px;
            }

            .row {
                display: flex;
                justify-content: space-between;
                margin-bottom: 10px;
            }

            .key {
                font-weight: bold;
                font-size: 19px;
                color: #2c3e50;
                /* Change color to your desired data key color */
            }

            .value {
                flex-grow: 1;
                text-align: right;
                color: #702a2a;
                font-size: 17px;
                /* Change color to your desired data value color */
            }

            .profile-container::before {
                content: "";
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset('images/background.jpg') }}');
                background-size: cover;
                background-position: center;
                z-index: -1;
                border-radius: 10px;
            }
            .update-password{
                display: flex;
                color: rgb(80, 80, 255);
                font-weight: 600;
            }
            .upload-photo{
                font-size: 18px;
                font-weight: 600;
            }
        </style>
    @endpush
    <div class="profile-container">
        <div class="avatar">
            @if ($user->avatar)
                <a href="{{ route('backend.user-upload_photo')}}"><img src="{{ asset('/avatars/full/'.$user->avatar) }}" alt="User Avatar"></a>
            @else
                <a class="upload-photo" href="{{ route('backend.user-upload_photo')}}">Upload a Photo</a>
            @endif
        </div>
        <div class="profile-details">
            <h2>{{ $user->name }}</h2>
            <div class="profile-info">
                <div class="row">
                    <span class="key">Email:</span>
                    <span class="value">{{ $user->email }}</span>
                </div>
                <div class="row">
                    <span class="key">Role:</span>
                    <span class="value">{{ $user->role->title }}</span>
                </div>
                <div class="row">
                    <span class="key">Alias Name:</span>
                    <span class="value">{{ $user->alias_name }}</span>
                </div>
                <div class="row">
                    <span class="key">Designation:</span>
                    <span class="value">{{ ucfirst($user->designation) }}</span>
                </div>
                <div class="row">
                    <span class="key">Employment Type:</span>
                    <span class="value">{{ ucwords($user->employment_type) }}</span>
                </div>
            </div>
        </div>
        <span class="update-password"><a href="{{ route("backend.user-update_password") }}">Update Password</a></span>
    </div>
@endsection
