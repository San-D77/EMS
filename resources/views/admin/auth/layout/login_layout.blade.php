<!doctype html>
<html lang="en" class="light-theme">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- loader-->
    <link href="{{ asset('') }}backend/assets/css/pace.min.css" rel="stylesheet" />
    <script src="{{ asset('') }}backend/assets/js/pace.min.js"></script>

    <!--plugins-->
    <link href="{{ asset('') }}backend/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />

    <!-- CSS Files -->
    <link href="{{ asset('') }}backend/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('') }}backend/assets/css/bootstrap-extended.css" rel="stylesheet">
    <link href="{{ asset('') }}backend/assets/css/style.css" rel="stylesheet">
    <link href="{{ asset('') }}backend/assets/css/icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">

    @stack('styles')
    <title> Login </title>
</head>

<body class="bg-white">

    <!--start wrapper-->
    <div class="wrapper">
        <div class="">
            <div class="row g-0 m-0">
                <div class="col-xl-6 col-lg-12">
                   @yield('content')
                </div>
                <div class="col-xl-6 col-lg-12">
                    <div class="position-fixed top-0 h-100 d-xl-block d-none login-cover-img">
                    </div>
                </div>
            </div>
            <!--end row-->
        </div>
    </div>
    <!--end wrapper-->



    @stack('scripts')
</body>

</html>
