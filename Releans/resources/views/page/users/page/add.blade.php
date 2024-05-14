@extends('layout.master')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>User</h1>

            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>Add User Form</h4>
                    </div>
                    <form id="addNewUser" method="POST" action="">
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputName4">Name</label>
                                    <input type="text" class="form-control" id="inputName4" name="name"
                                        placeholder="Name">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputPhoned4">Phone</label>
                                    <input type="text" class="form-control" id="inputPhoned4" name="phone"
                                        placeholder="Phone">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputEmail4">Email</label>
                                    <input type="email" class="form-control" id="inputEmail4" name="email"
                                        placeholder="Email">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputPassword4">Password</label>
                                    <input type="password" class="form-control" id="inputPassword4" name="password"
                                        placeholder="Password">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <div class="col-form-label col-sm-3 pt-0">Role</div>
                                    <div class="col-sm-9">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="role" value="admin"
                                                checked>
                                            <label class="form-check-label" for="gridRadios1">ADMIN</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="role" value="user">
                                            <label class="form-check-label">USER</label>
                                        </div>
                                        <div class="form-check disabled">
                                            <input class="form-check-input" type="radio" name="role" value="manager">
                                            <label class="form-check-label">MANAGER</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <!-- Changed button type to "submit" -->
                        </div>
                    </form>


                </div>

            </div>
        </section>

    </div>




    <script>
        const addNewUser = document.getElementById('addNewUser');

        addNewUser.addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(addNewUser);
            const name = formData.get('name');
            const email = formData.get('email');
            const password = formData.get('password');
            const phone = formData.get('phone');
            const role = formData.get('role');

            if (!name || !email || !password || !phone) {
                iziToast.error({
                    title: 'Error',
                    message: 'Enter all information.',
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

            if (phone.length !== 10) {
                iziToast.warning({
                    title: 'Error',
                    message: 'Phone must be exactly 10 numbers.',
                    position: 'topRight'
                });
                return;
            }

            const userData = {
                name: name,
                email: email,
                password: password,
                phone: phone,
                role: role
            };

            console.log('UserData:', userData);

            fetch('http://127.0.0.1:8000/api/newUser', {
                    method: 'POST',
                    body: formData,
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
                    if (data.status === 422) {
                        iziToast.error({
                            title: 'Error',
                            message: data.message,
                            position: 'topRight'
                        });
                    } else {
                        Swal.fire({
                            icon: "success",
                            title: "User created successfully",
                            showConfirmButton: false,
                            timer: 12000
                        });
                        Swal.showLoading();
                        setTimeout(() => {
                            window.location.href = 'http://127.0.0.1:8000/allUser';
                        }, 2000);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    iziToast.error({
                        title: 'Error',
                        message: 'Check what you entered.',
                        position: 'topRight'
                    })
                });

        });
    </script>
@endsection
