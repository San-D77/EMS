@extends('admin.backend.layouts.index')
@section('content')
    @push('styles')
        <style>
            h3{
                text-align: center;
                text-transform: capitalize;
            }
            .date {
                color: green;
                display:flex;
                justify-content: end;
                font-weight: 600;
                font-size: 19px;
            }
            p{
                margin-top:40px;
                font-size: 19px;
            }
        </style>
    @endpush
    <div>
        <h3>
            {{ $notice->title }}
        </h3>
        <span class="date">{{ toBikramSambatDate($notice->created_at) }}</span>
    </div>
    <p>{!! $notice->description !!}</p>
@endsection
