@include('admin.backend.layouts.partials.header')
@include('admin.backend.layouts.partials.navbar')
@include('admin.backend.layouts.partials.sidebar')
<div class="page-wrapper">
    <div class="page-content">
        @include('notification')
        @yield('content')
    </div>
@include('admin.backend.layouts.partials.footer')
