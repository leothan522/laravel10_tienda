<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>
        @yield('title_prefix', config('adminlte.title_prefix', ''))
        @yield('title', config('adminlte.title', 'Multishop'))
        @yield('title_postfix', config('adminlte.title_postfix', ''))
    </title>

    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicons/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicons/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicons/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicons/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicons/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicons/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicons/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicons/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicons/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicons/favicon-16x16.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicons/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('favicons/android-icon-192x192.png') }}">
    <link rel="manifest" crossorigin="use-credentials" href="{{ asset('favicons/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('favicon/ms-icon-144x144.png') }}">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    {{--<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">--}}
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('vendor/multishop/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/multishop/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('vendor/multishop/css/style.css') }}" rel="stylesheet">

    {{-- boxicons --}}
    <link rel="stylesheet" href="{{ asset('vendor/boxicons/css/boxicons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/web-style.css') }}">
    @livewireStyles
    @yield('css')
</head>

<body>

<!-- Topbar Start -->
@include('vendor.multishop.partials.topbar.topbar')
<!-- Topbar End -->

<!-- Navbar Start -->
@include('vendor.multishop.partials.navbar.navbar')
<!-- Navbar End -->

<!-- Content Start -->
@yield('content')
<!-- Content End -->

<!-- Footer Start -->
@include('vendor.multishop.partials.footer.footer')
<!-- Footer End -->

<!-- Back to Top -->
<a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


<!-- JavaScript Libraries -->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}{{--https://code.jquery.com/jquery-3.4.1.min.js--}}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}{{--https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js--}}"></script>
<script src="{{ asset('vendor/multishop/lib/easing/easing.min.js') }}"></script>
<script src="{{ asset('vendor/multishop/lib/owlcarousel/owl.carousel.min.js') }}"></script>

<!-- Contact Javascript File -->
<script src="{{ asset('vendor/multishop/mail/jqBootstrapValidation.min.js') }}"></script>
<script src="{{ asset('vendor/multishop/mail/contact.js') }}"></script>

<!-- Template Javascript -->
<script src="{{ asset('vendor/multishop/js/main.js') }}"></script>


@livewireScripts

{{-- Sweetalert2 --}}
<script src="{{ asset('vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>
<x-livewire-alert::scripts />

{{-- JS Personalizado--}}
<script src="{{ asset('js/sweetalert-app.js') }}"></script>
<script src="{{ asset('js/web-app.js') }}"></script>
@yield('js')
</body>

</html>
