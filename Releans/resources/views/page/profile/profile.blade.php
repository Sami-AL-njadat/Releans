@extends('layout.master')

@section('content')
    <div id="app">
        <div class="main-wrapper main-wrapper-1">



            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>Profile</h1>

                    </div>
                    <div class="section-body">
                        <h2 class="section-title">Hi, {{ Auth::user()->name }}!</h2>


                        <p class="section-lead">
                            Change information about yourself on this page.
                        </p>

                        <div class="row mt-sm-4">
                            <div class="col-12 col-md-12 col-lg-5">
                                <div class="card profile-widget">
                                    <div class="profile-widget-header">
                                        <img alt="image" src="{{ Auth::user()->image }}"
                                            class="rounded-circle profile-widget-picture">

                                    </div>
                                    <div class="profile-widget-description">
                                        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'manager')
                                            <div class="profile-widget-name">Your position :
                                                <div class="text-muted d-inline font-weight-normal">
                                                    <div class="slash"></div> {{ Auth::user()->role }}
                                                </div>
                                            </div>
                                        @endif
                                        <div class="profile-widget-name">Phone : <div
                                                class="text-muted d-inline font-weight-normal">
                                                <div class="slash"></div> {{ Auth::user()->phone }}
                                            </div>
                                        </div>
                                        <div class="profile-widget-name">Email : <div
                                                class="text-muted d-inline font-weight-normal">
                                                <div class="slash"></div> {{ Auth::user()->email }}
                                            </div>
                                        </div>
                                    </div>

                                </div>




                                <div class="card profile-widget">
                                    <form method="post" id="newpassword">
                                        @csrf
                                        <input type="hidden" name="iduser" id="iduser" value="{{ Auth::user()->id }}">

                                        <div class="form-group col-md-6 col-12">
                                            <label>Old password</label>
                                            <input name="old_password" type="password" class="form-control" required
                                                value="">

                                        </div>
                                        <div class="form-group col-md-6 col-12">
                                            <label>New password</label>
                                            <input name="new_password" type="password" class="form-control" value=""
                                                required>

                                        </div>


                                        <div class="form-group col-md-6 col-12">
                                            <label>Confirm password</label>
                                            <input name="confirm" type="password" class="form-control" value=""
                                                required>

                                        </div>
                                        <div class="card-footer text-right">
                                            <button class="btn btn-primary">Save Now Password</button>
                                        </div>
                                    </form>

                                </div>


                            </div>



                            <div class="col-12 col-md-12 col-lg-7">
                                <div class="card">
                                    <form id="editInformation" method="post">
                                        @csrf
                                        <input type="hidden" name="userId" id="userId" value="{{ Auth::user()->id }}">

                                        <div class="card-header">
                                            <h4>Edit Profile</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="form-group col-md-6 col-12">
                                                    <label>Name</label>
                                                    <input name="name" type="text" class="form-control"
                                                        value="{{ Auth::user()->name }}">
                                                    <div class="invalid-feedback">
                                                        Please fill in the first name
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 col-12">
                                                    <label>Email</label>
                                                    <input name="email" type="email" class="form-control"
                                                        value="{{ Auth::user()->email }}">
                                                    <div class="invalid-feedback">
                                                        Please fill in the email
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">

                                                <div class="form-group col-md-6 col-12">
                                                    <label>Phone</label>
                                                    <input name="phone" type="tel" class="form-control"
                                                        value="{{ Auth::user()->phone }}">
                                                    <div class="invalid-feedback">
                                                        Please fill in the phone
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 col-12">
                                                    <label>Image</label>
                                                    <input name="image" type="file" class="form-control"
                                                        accept="image/*">

                                                </div>


                                            </div>





                                        </div>
                                        <div class="card-footer text-right">
                                            <button class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

        </div>
    </div>


    <script>
        addform = document.querySelector('#editInformation');
        addform.addEventListener('submit', function(event) {
            event.preventDefault();

            var formData = new FormData(addform);
            var name = formData.get('name');
            var email = formData.get('email');
            var phone = formData.get('phone');
            var image = formData.get('image');
            var userId = formData.get('userId');

            var userId = document.getElementById('userId').value;

            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            formData.append('_method', 'POST');

            fetch(`http://127.0.0.1:8000/api/editProfileInfo/${userId}`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': token
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Success:', data);
                    swal('Good Job', 'The Information Edit Successful ', 'success')
                        .then(() => {
                            window.location.href = 'http://127.0.0.1:8000/ProfileUsers';
                        });
                })
                .catch(error => {
                    console.error('Error:', error);
                    swal('Error', 'You Entered Wrong Type of Data!', 'warning')
                        .then(() => {
                            window.location.href = 'http://127.0.0.1:8000/ProfileUsers';
                        });
                });
        });
    </script>


    <script>
        document.getElementById('newpassword').addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(this);
            var userId = formData.get('iduser');
            var old_password = formData.get('old_password');
            var new_password = formData.get('new_password');
            var confirm = formData.get('confirm');

            if (new_password !== confirm) {
                iziToast.error({
                    title: 'Error',
                    message: 'Password and Password Confirmation do not match.',
                    position: 'topRight'
                });
                return;
            }

            if (new_password.length < 8) {
                iziToast.warning({
                    title: 'Error',
                    message: 'Password must be at least 8 characters long.',
                    position: 'topRight'
                });
                return;
            }

            fetch(`http://127.0.0.1:8000/api/PassWordRest/${userId}`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 200) {
                        swal('Good Job', `${data.message}`, 'success')
                            .then(() => {
                                window.location.href = 'http://127.0.0.1:8000/ProfileUsers';
                            });

                    } else {
                        iziToast.warning({
                            title: 'Error',
                            message: `${data.message}`,
                            position: 'topRight'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    </script>
@endsection
