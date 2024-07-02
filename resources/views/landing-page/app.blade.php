<!DOCTYPE html>

<html lang="en">

<head>

    <!-- ** Basic Page Needs ** -->
    <meta charset="utf-8">
    <title>SIPEB2M - @yield('title')</title>

    <!-- ** Mobile Specific Metas ** -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Vex HTML Template">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="author" content="Themefisher">
    <meta name="generator" content="Themefisher Vex HTML Template v1.0">

    <!-- theme meta -->
    <meta name="theme-name" content="vex" />

    <!-- ** Plugins Needed for the Project ** -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Droid&#43;Serif:400%7cJosefin&#43;Sans:300,400,600,700 ">
    <link rel="stylesheet" href="{{ asset('assets/lp-pluggins/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/lp-pluggins/themefisher-font/themefisher-font.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/lp-pluggins/slick/slick.min.css') }}">

    <!-- Stylesheets -->
    <link href="{{ asset('assets/css/lp-style.css') }}" rel="stylesheet">

    <!--Favicon-->
    <link rel="icon" href="{{ asset('assets/img/logo.svg') }}" type="image/x-icon">

</head>

<body id="body">

    <!-- preloader start -->
    <div class="preloader"></div>
    <!-- preloader end -->

    <!--Header-->
    @include('landing-page.header')

    <!--Content-->
    @yield('content')

    <script src="{{ asset('assets/lp-pluggins/jquery/jquery.js') }}"></script>

    <script src="{{ asset('assets/lp-pluggins/bootstrap/bootstrap.min.js') }}"></script>

    <script src="{{ asset('assets/lp-pluggins/slick/slick.min.js') }}"></script>

    <script src="{{ asset('assets/js/lp-script.js') }}"></script>
</body>

</html>
@include('landing-page.footer')
