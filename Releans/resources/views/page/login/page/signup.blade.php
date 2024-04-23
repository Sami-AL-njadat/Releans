@extends('page/login/layout/layout')

@section('content')
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
                        <div class="login-brand">
                            <img src="{{ asset('frontend/logo/logo.png') }}" alt="logo" width="100px">

                        </div>

                        <div class="card card-primary">
                            <div class="card-header">
                                <h4>Register</h4>
                            </div>

                            <div class="card-body">
                                <form id="registerForm" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="name"> Name</label>
                                            <input id="name" type="text" class="form-control" name="name"
                                                autofocus required>
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                required>
                                        </div>
                                    </div>



                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="password" class="d-block">Password</label>
                                            <input required id="password" type="password" class="form-control pwstrength"
                                                data-indicator="pwindicator" name="password">
                                            <div id="pwindicator" class="pwindicator">
                                                <div class="bar"></div>
                                                <div class="label"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="password_confirmation" class="d-block">Password Confirmation</label>
                                            <input required id="password_confirmation" type="password" class="form-control"
                                                name="password_confirmation">
                                        </div>
                                    </div>



                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label>Phone</label>
                                            <input required name=phone type="phone" class="form-control">
                                        </div>

                                    </div>


                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                                            Register
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="mt-5 text-muted text-center">
                            I have a account already ! <a href="{{ route('login.page') }}">sign in</a>
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
        const registerForm = document.getElementById('registerForm');

        registerForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(registerForm);
            const name = formData.get('name');
            const email = formData.get('email');
            const password = formData.get('password');
            const password_confirmation = formData.get('password_confirmation');
            const phone = formData.get('phone');
            // Add other form data fields as needed

            // Check if required fields are not empty
            if (!name || !email || !password || !password_confirmation || !phone) {
                iziToast.error({
                    title: 'Error',
                    message: 'Enter all information.',
                    position: 'topRight'
                });
                return;
            }

            // Check if password and password confirmation match
            if (password !== password_confirmation) {
                iziToast.error({
                    title: 'Error',
                    message: 'Password and Password Confirmation do not match.',
                    position: 'topRight'
                });
                return;
            }

            if (password.length < 8) {
                iziToast.warning({
                    title: 'Error',
                    message: 'Password must be at least 8 characters long.',
                    position: 'topRight'
                });
                return;
            }

            if (phone.length < 10 || phone.length > 10) {
                iziToast.warning({
                    title: 'Error',
                    message: 'phone must be at 10 number.',
                    position: 'topRight'
                });
                return;
            }

            const userData = {
                name: name,
                email: email,
                password: password,
                password_confirmation: password_confirmation,
                phone: phone,
            };

            console.log('UserData:', userData);

            // Fetch API to send form data to the backend
            fetch('http://127.0.0.1:8000/api/createUser', {
                    method: 'POST',
                    body: formData, // Send form data
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    localStorage.setItem('access_token', data.token);
                    console.log('access_token', data.token);
                    console.log('token', data);
                    console.log('Success:', data);
                    Swal.fire({
                        icon: "success",
                        title: "User created successfully",
                        showConfirmButton: false,
                        timer: 12000 // 2 seconds
                    });

                    // Redirect the user to the login page
                    Swal.showLoading(); // Show loading animation in the meantime
                    setTimeout(() => {
                        window.location.href = 'http://127.0.0.1:8000/';
                    }, 2000);
                })

                .catch(error => {
                    console.error('Error:', error);
                    console.log('Error:', data);
                    iziToast.Error({
                        title: 'Error',
                        message: 'check what you enter .',
                        position: 'topRight'
                    })
                });
        });
    </script>
@endsection
