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
            <section class="section">
                <div class="container mt-5">
                    <div class="row">
                        <div
                            class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                            <div class="login-brand">
                                <img src="{{ asset('frontend/assets/img/stisla-fill.svg') }}" alt="logo"
                                    width="100" class="shadow-light rounded-circle">
                            </div>

                            <div class="card card-primary">
                                <div class="card-header">
                                    <h4>Login</h4>
                                </div>

                                <div class="card-body">
                                    <form id="loginForm" class="needs-validation" novalidate="">
                                        <!-- CSRF Token -->
                                        @csrf

                                        <!-- Email input -->
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input id="email" type="email" class="form-control" name="email"
                                                tabindex="1" required autofocus>
                                            <div class="invalid-feedback">Please fill in your email</div>
                                        </div>

                                        <!-- Password input -->
                                        <div class="form-group">
                                            <div class="d-block">
                                                <label for="password" class="control-label">Password</label>
                                                <div class="float-right">
                                                    <a href="auth-forgot-password.html" class="text-small">Forgot
                                                        Password?</a>
                                                </div>
                                            </div>
                                            <input id="password" type="password" class="form-control" name="password"
                                                tabindex="2" required>
                                            <div class="invalid-feedback">Please fill in your password</div>
                                        </div>

                                        <!-- Submit button -->
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-lg btn-block"
                                                tabindex="4">Login</button>
                                        </div>
                                    </form>



                                </div>
                            </div>
                            <div class="mt-5 text-muted text-center">
                                Don't have an account? <a href="auth-register.html">Create One</a>
                            </div>
                            <div class="simple-footer">
                                Copyright &copy; Stisla 2018
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>




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
        <script>
            document.getElementById('loginForm').addEventListener('submit', function(event) {
                event.preventDefault();

                var formData = new FormData(this);
                var email = formData.get('email');
                var password = formData.get('password');

                if (!email || !password) {
                    iziToast.error({
                        title: 'Error',
                        message: 'Invalid credentials. Please enetr your email and pssword.',
                        position: 'topRight'
                    });
                    return;
                }

                var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                formData.append('_token', token);
                console.log('_token,', token);

                fetch('http://127.0.0.1:8000/api/login/accessToken', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Authentication failed');
                        }
                        return response.json();
                    })
                    .then(data => {
                        localStorage.setItem('access_token', data.token);
                        console.log('access_token', data.token);
                        console.log('token', data);
                        iziToast.success({
                            title: 'success',
                            message: 'valid credentials. WELCOME.',
                            position: 'topRight',

                        })
                        window.location.href =
                            'http://127.0.0.1:8000/';

                    })
                    .catch(error => {
                        console.error('Error:', error);

                        if (error.message === 'Authentication failed') {
                            iziToast.warning({
                                title: 'Error',
                                message: 'Invalid credentials. ((Please !)) check your email and password.',
                                position: 'topRight'
                            });
                        } else {
                            iziToast.error({
                                title: 'Error',
                                message: 'An error occurred while trying to authenticate. Please try again later.',
                                position: 'topRight'
                            });
                        }
                    });
            });
        </script>

        {{-- <script>
            document.getElementById('loginForm').addEventListener('submit', function(event) {
                event.preventDefault();

                var formData = new FormData(this);
                var email = formData.get('email');
                var password = formData.get('password');

                if (!email || !password) {
                    alert("Please fill out all fields.");
                    return;
                }

                var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                formData.append('_token', token);

                fetch('{{ route('logins') }}', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => {
                        if (response.ok) {
                            // Authentication successful
                            return response.json();
                        } else {
                            // Authentication failed
                            throw new Error('Authentication failed');
                        }
                    })
                    .then(data => {
                        // Handle additional data if needed
                        localStorage.setItem('access_token', data.token);
                        window.location.href = 'http://127.0.0.1:8000/dashboard';
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        iziToast.error({
                            title: 'Error',
                            message: 'An error occurred while trying to authenticate. Please try again later.',
                            position: 'topRight'
                        });
                    });
            });
        </script> --}}

    </body>

    </html>
