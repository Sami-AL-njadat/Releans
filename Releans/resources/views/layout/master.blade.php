<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Ecommerce Dashboard &mdash; Stisla</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('frontend/assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/modules/fontawesome/css/all.min.css') }}">
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/modules/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/modules/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('frontend/assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css') }}">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/modules/datatables/datatables.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('frontend/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('frontend/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/components.css') }}">
    <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-94034622-3');
    </script>
    <!-- /END GA -->
</head>

<body>


    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            @include('layout.nav')
            @include('layout.saidbar')
            @yield('content')

            @include('layout.footer')
            <script type="text/javascript">
                // Initialize the loading screen
                window.loading_screen = window.pleaseWait({
                    logo: "frontend/assets/img/americanexpress.png", // Path to your custom logo image
                    backgroundColor: '#ffffff', // Background color of the loading screen
                    loadingHtml: 'Add your custom HTML here' // Custom HTML content for the loading screen
                });
            </script>

            <!-- Your content here -->

            <script>
                // Finish loading (remove the loading screen)
                window.loading_screen.finish();
            </script>
