    <!DOCTYPE html>
    <html lang="en">


    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
        <title>Login &mdash; Stisla</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="stylesheet" href="{{ asset('frontend/assets/modules/izitoast/css/iziToast.min.css') }}">

        <!-- General CSS Files -->
        <link rel="stylesheet" href="{{ asset('frontend/assets/modules/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/assets/modules/fontawesome/css/all.min.css') }}">

        <!-- CSS Libraries -->
        <link rel="stylesheet" href="{{ asset('frontend/assets/modules/bootstrap-social/bootstrap-social.css') }}">

        <!-- Template CSS -->
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/components.css') }}">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

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

        @yield('content')




        <script src="{{ asset('frontend/assets/modules/izitoast/js/iziToast.min.js') }}"></script>
        {{-- <script src="{{ asset('frontend/assets/js/page/modules-toastr.js') }}"></script>    --}}
        <script src="{{ asset('frontend/assets/modules/jquery.min.js') }}"></script>
        <script src="{{ asset('frontend/assets/modules/popper.js') }}"></script>
        <script src="{{ asset('frontend/assets/modules/tooltip.js') }}"></script>
        <script src="{{ asset('frontend/assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('frontend/assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
        <script src="{{ asset('frontend/assets/modules/moment.min.js') }}"></script>
        <script src="{{ asset('frontend/assets/js/stisla.js') }}"></script>


        <script src="{{ asset('frontend/assets/js/scripts.js') }}"></script>
        <script src="{{ asset('frontend/assets/js/custom.js') }}"></script>



    </body>

    </html>
