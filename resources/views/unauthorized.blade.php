@extends('admin.backend.layouts.index')
@section('content')
    @push('styles')
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f3f3f3;
                margin: 0;
                padding: 0;
            }

            .container {
                max-width: 800px;
                margin: 0 auto;
                padding: 20px;
                text-align: center;
            }

            h1 {
                font-size: 48px;
                color: #ff6347;
            }

            p {
                font-size: 18px;
                color: #555;
            }

            .emoji {
                font-size: 100px;
            }

            .link {
                color: #0066cc;
                text-decoration: none;
            }
        </style>
    @endpush


    <div class="container">
        <h1>Unauthorized Access</h1>
        <p>Oops! You don't have permission to access this page.</p>
        <div class="emoji">😕</div>
    </div>
@endsection
