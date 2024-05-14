@extends('layout.master')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>User Tables</h1>

            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>User Tables</h4>
                                <a class="btn btn-success" href="{{ route('add.page') }}"> Add user</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">ID</th>
                                                <th>Name</th>
                                                <th>Image</th>
                                                <th>Email</th>
                                                <th>Phone </th>
                                                <th>Role</th>
                                                <th class="text-right">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="authTable">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.min.js"></script>

    <script>
        fetch('http://127.0.0.1:8000/api/allUsers')
            .then(response => response.json())
            .then(data => {
                if (data && data.user) {
                    data.user.forEach(user => {
                        const row = `
                    <tr>
                         <td>${user.id}</td>
                         <td>${user.name}</td>
                        <td><img style="border-radius: 100%;width: 85px;height: 80px;" src="${user.image}" alt=""></td>
                        <td>${user.email}</td>
                        <td>${user.phone}</td>
                          <td>
                            <select class="form-control role-select" data-user-id="${user.id}">
                                <option value="admin" ${user.role === 'admin' ? 'selected' : ''}>Admin</option>
                                <option value="manager" ${user.role === 'manager' ? 'selected' : ''}>Manager</option>
                                <option value="user" ${user.role === 'user' ? 'selected' : ''}>User</option>
                            </select>
                        </td>

                         <td class="text-right">
                            <a href="#" class="btn btn-danger" onclick="confirmDelete(${user.id})">Delete</a>

                                </td>
                        </tr>`;
                        document.getElementById('authTable').innerHTML += row;
                    });
                    document.querySelectorAll('.role-select').forEach(select => {
                        select.addEventListener('change', function() {
                            const userId = this.dataset.userId;
                            const newRole = this.value;

                            fetch(`http://127.0.0.1:8000/api/user/${userId}/role`, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': token
                                    },
                                    body: JSON.stringify({
                                        role: newRole
                                    })
                                })
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error('Failed to update user role');
                                    }
                                    swal('Success', 'User role updated successfully',
                                            'success')
                                        .then(() => {
                                            window.location.href =
                                                'http://127.0.0.1:8000/allUser';
                                        });
                                })
                                .catch(error => {
                                    console.error('Error:', error.message);
                                    swal('Error', 'Failed to update user role',
                                            'error')
                                        .then(() => {
                                            window.location.href =
                                                'http://127.0.0.1:8000/allUser';
                                        });
                                });
                        });
                    });
                } else {
                    console.error('Error: Users data is missing or invalid');
                }
            })
            .catch(error => console.error('Error fetching user data:', error));


        function confirmDelete(userId) {
            swal({
                    title: 'Are you sure?',
                    text: 'Once deleted, you will not be able to recover this product!',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        deleteUser(userId);
                    } else {
                        swal('user deletion canceled!', {
                            icon: 'info',
                        });
                    }
                });
        }

        function deleteUser(userId) {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(`http://127.0.0.1:8000/api/user/delete/${userId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token

                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to delete user');
                    }
                    swal('Poof! user has been deleted!', {
                            icon: 'success',
                        })

                        .then(() => {
                            window.location.href = 'http://127.0.0.1:8000/allUser';
                        })
                })
                .catch(error => {
                    console.error('Error:', error.message);


                    swal('Error', 'Failed to delete user', 'error')
                        .then(() => {
                            window.location.href = 'http://127.0.0.1:8000/allUser  ';
                        })
                });
        }
    </script>
@endsection
