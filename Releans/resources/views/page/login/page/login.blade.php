@extends('page/login/layout/layout')

@section('content')
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                        <div class="login-brand">
                            <img src="{{ asset('frontend/logo/logo.png') }}" alt="logo" width="100px">
                        </div>

                        <div class="card card-primary">
                            <div class="card-header">
                                <h4>Login</h4>
                            </div>

                            <div class="card-body">
                                <form method="POST" id="loginForm" class="needs-validation" novalidate="">
                                    @csrf

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

                                        </div>
                                        <input id="password" type="password" class="form-control" name="password"
                                            tabindex="2" required>
                                        <div class="invalid-feedback">Please fill in your password</div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block"
                                            tabindex="4">Login</button>
                                    </div>
                                </form>



                            </div>
                        </div>
                        <div class="mt-5 text-muted text-center">
                            Don't have an account? <a href="{{ route('signup.page') }}">Create One</a>
                        </div>
                        <div class="simple-footer">
                            Copyright &copy; Relens 2024
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>



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
                    Swal.fire({
                        icon: "success",
                        title: "successfully login",
                        showConfirmButton: false,
                        timer: 5000
                    });

                    Swal.showLoading();
                    setTimeout(() => {
                        window.location.href = 'http://127.0.0.1:8000/';
                    }, 2000);
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
@endsection
