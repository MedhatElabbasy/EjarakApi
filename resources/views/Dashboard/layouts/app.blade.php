<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Title -->
    <title>@yield('title')</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="DexignaZone">
    <meta name="robots" content="">

    <meta name="keywords"
        content="accommodation, admin dashboard, admin template, apartment, booking, bootstrap 5, dinning, hostel, hotel booking, hotel template, motel, resort, restaurant, room">
    <meta name="description"
        content="Innap is a clean-coded, responsive HTML template that can be easily customised to fit the needs of various hotel booking and hotel template, booking, dinning, hostel, and other businesses">

    <meta property="og:title" content="Innap - Hotel Admin Dashboard Bootstrap Templates">
    <meta property="og:description"
        content="Innap is a clean-coded, responsive HTML template that can be easily customised to fit the needs of various hotel booking and hotel template, booking, dinning, hostel, and other businesses">
    <meta property="og:image" content="https://innap.dexignzone.com/xhtml/social-image.png">
    <meta name="format-detection" content="telephone=no">

    <!-- Mobile Specific -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon icon -->
    <link rel="shortcut icon" type="{{ asset('assets/image/x-icon') }}" href="{{ asset('assets/images/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/chartist/css/chartist.min.css') }}">
    <link href="{{ asset('assets/vendor/jquery-nice-select/css/nice-select.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}"
        rel="stylesheet">
    <!-- Style css -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    @livewireStyles

</head>

<body>
    <div id="preloader">
        <div class="waviy">
            <span style="--i:1">L</span>
            <span style="--i:2">o</span>
            <span style="--i:3">a</span>
            <span style="--i:4">d</span>
            <span style="--i:5">i</span>
            <span style="--i:6">n</span>
            <span style="--i:7">g</span>
            <span style="--i:8">.</span>
            <span style="--i:9">.</span>
            <span style="--i:10">.</span>
        </div>
    </div>


    <div id="main-wrapper">

        @include('Dashboard.layouts.header')
        @include('Dashboard.layouts.sidebar')


        <div class="content-body">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>





    <div class="footer">

        <div class="copyright">
            <p>Copyright © Designed &amp; Developed by <a href="#" target="_blank">DexignZone</a> 2023</p>
        </div>
    </div>
    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->



    <script src="{{ asset('assets/vendor/global/global.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/chart.js/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-nice-select/js/jquery.nice-select.min.js') }}"></script>
    <!-- Chart piety plugin files -->
    <script src="{{ asset('assets/vendor/peity/jquery.peity.min.js') }}"></script>

    <!-- Apex Chart -->
    <script src="{{ asset('assets/vendor/apexchart/apexchart.js') }}"></script>

    <script src="{{ asset('assets/vendor/bootstrap-datetimepicker/js/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>

    <!-- Dashbo ard 1 -->
    <script src="{{ asset('assets/js/dashboard/dashboard-1.js') }}"></script>
    <script src="{{ asset('assets/js/custom.min.js') }}"></script>
    <script src="{{ asset('assets/js/deznav-init.js') }}"></script>
    <script src="{{ asset('assets/js/ar/RTL.JS') }}"></script>

    <script src="{{ asset('assets/js/demo.js') }}"></script>
    <script src="{{ asset('assets/js/styleSwitcher.js') }}"></script>
    <script src="{{ asset('assets/js/ar/RTL.JS') }}"></script>

    <script>
        $(function() {
            $('#datetimepicker').datetimepicker({
                inline: true,
            });
        });

        $(document).ready(function() {
            $(".booking-calender .fa.fa-clock-o").removeClass(this);
            $(".booking-calender .fa.fa-clock-o").addClass('fa-clock');
        });
    </script>
    @livewireScripts
    @yield('script')
</body>

</html>
