@extends('layout.master')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>DataTables</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Modules</a></div>
                    <div class="breadcrumb-item">DataTables</div>
                </div>
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
                                                <th class="text-center">Id</th>
                                                <th>name</th>
                                                <th>Image</th>
                                                <th>Email</th>
                                                <th>Phone </th>
                                                <th>Role</th>
                                                <th class="text-right">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="userTable">

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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('http://127.0.0.1:8000/api/allUsers')
                .then(response => response.json())
                .then(data => {

                    if (data && data.user) {
                        data.user.forEach(user => {

                            const row = `
                        <tr>
                            <td>${user.id}</td>
                            <td>${user.name}</td>
                            <td><img style="border-radius: 100%;width: 91px;height:80px;" src="${user.image}" alt=""></td>
                            <td>${user.email}</td>
                            <td>${user.phone}</td>
                            <td>${user.role}</td>
                            <td class="text-right">
    <a href="#" class="btn btn-danger" onclick="confirmDelete(${user.id})">Delete</a>
                            </td>
                        </tr>`;
                            document.getElementById('userTable').innerHTML += row;
                        });
                    } else {
                        console.error('Error: Users data is missing or invalid');
                    }
                })
                .catch(error => console.error('Error fetching user data:', error));
        });




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
