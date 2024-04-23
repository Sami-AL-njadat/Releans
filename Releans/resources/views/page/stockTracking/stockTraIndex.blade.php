@extends('layout.master')

@section('content')
    @if (session()->has('error'))
        <script>
            alert('{{ session('error') }}');
        </script>
    @endif

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
                                <h4>Stock Tracking Add Or Deduction Tables</h4>
                                <a class="btn btn-success" href="{{ route('add.Track') }}"> Stock Tracking</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Total quantity</th>
                                                <th>Type of Transaqtion</th>
                                                <th>quantity of Transaqtion </th>
                                                <th>Resoun</th>
                                                <th>Description</th>
                                                <th class="text-right">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="stockTable">

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
        fetch('http://127.0.0.1:8000/api/allTransaction')
            .then(response => response.json())
            .then(data => {
                if (data && data.stock) {
                    const stock = data.stock;

                    const stockTableBody = document.querySelector('#stockTable');
                    stock.forEach(stockItem => {
                        const productName = stockItem.product.name || 'Unknown Product';
                        const productQuantity = stockItem.product.quantity || 'Unknown quantity';

                        const row = `
                    <tr>
                         <td>${productName}</td>
                        <td>${productQuantity}</td>
                        <td>${stockItem.type}</td>
                        <td>${stockItem.quantities}</td>
                        <td>${stockItem.reason}</td>
                        <td>${stockItem.description}</td>
                        <td class="text-right">
                            <a href="{{ route('edit.Track', ['id' => '']) }}/${stockItem.id}" class="btn btn-primary">Edit</a>
                            <a href="#" class="btn btn-danger" onclick="confirmDelete(${stockItem.id})">Delete</a>
                        </td>
                    </tr>`;
                        stockTableBody.innerHTML += row;
                    });

                } else {
                    console.error('Error: stock data is missing or invalid');
                }
            })
            .catch(error => console.error('Error fetching stock data:', error));



        function confirmDelete(stockId) {
            swal({
                    title: 'Are you sure?',
                    text: 'Once deleted, you will not be able to recover this Stock!',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        deleteStock(stockId);
                    } else {
                        swal('Stock deletion canceled!', {
                            icon: 'info',
                        });
                    }
                });
        }


        function deleteStock(stockId) {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(`http://127.0.0.1:8000/api/deleteStock/${stockId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token

                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to delete Stock Tracking');
                    }
                    swal('Poof! Stock Tracking has been deleted!', {
                            icon: 'success',
                        })

                        .then(() => {
                            window.location.href = 'http://127.0.0.1:8000/stock';
                        })
                })
                .catch(error => {
                    console.error('Error:', error.message);


                    swal('Error', 'Failed to delete Stock Tracking', 'error')
                        .then(() => {
                            window.location.href = 'http://127.0.0.1:8000/stock';
                        })
                });
        }
    </script>
@endsection
