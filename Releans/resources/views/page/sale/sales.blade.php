@extends('layout.master')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Sale Tables</h1>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Sale Tables</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Product Name</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>User Name</th>
                                                <th>Total Price</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody id="saleTable">

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
        fetch('http://127.0.0.1:8000/api/allSale')
            .then(response => response.json())
            .then(data => {
                if (data && data.sales) {
                    data.sales.forEach(sale => {
                        const row = `
                        <tr>
                            <td>${sale.id}</td>
                            <td>${sale.product_name}</td>
                            <td>${sale.product_price}</td>
                            <td>${sale.quantities}</td>
                            <td>${sale.user_name}</td>
                            <td>${sale.total_price}</td>
                            <td>
                         <select class="form-control status-select ${sale.status === 'on hold' ? 'bg-warning' : sale.status === 'accept' ? 'bg-success' : 'bg-danger'}" data-sale-id="${sale.id}">
    <option value="on hold" ${sale.status === 'on hold' ? 'selected' : ''}>On hold</option>
    <option value="accept" ${sale.status === 'accept' ? 'selected' : ''} ${sale.status === 'reject' ? 'disabled' : ''}>Accept</option>
    <option value="reject" ${sale.status === 'reject' ? 'selected' : ''} ${sale.status === 'accept' ? 'disabled' : ''}>Reject</option>
</select>

                            </td>
                        </tr>`;
                        document.getElementById('saleTable').innerHTML += row;
                    });
                    document.querySelectorAll('.status-select').forEach(select => {
                        select.addEventListener('change', function() {
                            const saleId = this.dataset.saleId;
                            const newStatus = this.value;

                            fetch(`http://127.0.0.1:8000/api/updateSale/${saleId}`, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': token
                                    },
                                    body: JSON.stringify({
                                        status: newStatus
                                    })
                                })
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error('Failed to update user role');
                                    }
                                    swal('Success', 'Order status updated successfully', 'success')
                                        .then(() => {
                                            window.location.href = 'http://127.0.0.1:8000/sale';
                                        });
                                })

                                .catch(error => {
                                    console.error('Error:', error.message);
                                    swal('Error', 'Failed to update status', 'error')
                                        .then(() => {
                                            window.location.href = 'http://127.0.0.1:8000/sale';
                                        });
                                });
                        });
                    });
                } else {
                    console.error('Error: sales data is missing or invalid');
                }
            })
            .catch(error => console.error('Error fetching sales data:', error));
    </script>
@endsection
