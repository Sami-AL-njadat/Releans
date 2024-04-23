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
                                <h4>Product Tables</h4>
                                <a class="btn btn-success" href="{{ route('add.product') }}">Add new product</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">ID</th>
                                                <th>Name</th>
                                                <th>Image</th>
                                                <th>Status</th>
                                                <th>Quantity</th>
                                                <th>Minimum level</th>
                                                <th>Price</th>
                                                <th class="text-right">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="productTable">

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
        fetch('http://127.0.0.1:8000/api/allProduct')
            .then(response => response.json())
            .then(data => {
                if (data && data.product) {
                    data.product.forEach(product => {
                        const row = `
                    <tr>
                        <td>${product.id}</td>
                        <td>${product.name}</td>
                        <td><img style="border-radius: 120%;
    width: 91px;
    height: 80px;" src="${product.image}" alt=""></td>
                        <td>${product.status}</td>
                        <td>${product.quantity}</td>
                        <td>${product.minimum_level}</td>
                        <td>${product.price}</td>
                         <td class="text-right">

    <a href="{{ route('edit.product', ['id' => '']) }}/${product.id}" class="btn btn-primary">Edit</a>
    <a href="#" class="btn btn-danger" onclick="confirmDelete(${product.id})">Delete</a>
                                </td>
                        </tr>`;
                        document.getElementById('productTable').innerHTML += row;
                    });
                } else {
                    console.error('Error: Products data is missing or invalid');
                }
            })
            .catch(error => console.error('Error fetching product data:', error));



        function confirmDelete(productId) {
            swal({
                    title: 'Are you sure?',
                    text: 'Once deleted, you will not be able to recover this product!',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        deleteProduct(productId);
                    } else {
                        swal('Product deletion canceled!', {
                            icon: 'info',
                        });
                    }
                });
        }

        function deleteProduct(productId) {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(`http://127.0.0.1:8000/api/product/delete/${productId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token

                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to delete product');
                    }
                    swal('Poof! Product has been deleted!', {
                            icon: 'success',
                        })

                        .then(() => {
                            window.location.href = 'http://127.0.0.1:8000/product';
                        })
                })
                .catch(error => {
                    console.error('Error:', error.message);


                    swal('Error', 'Failed to delete product', 'error')
                        .then(() => {
                            window.location.href = 'http://127.0.0.1:8000/product';
                        })
                });
        }
    </script>
@endsection
