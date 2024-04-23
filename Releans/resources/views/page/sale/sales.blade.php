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
                                                <th>Product Name</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>User Name</th>
                                                <th>Total Price</th>
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
                                <td>${sale.product_name}</td>
                                <td>${sale.product_price}</td>
                                <td>${sale.quantities}</td>
                                <td>${sale.user_name}</td>
                                <td>${sale.total_price}</td>
                            </tr>`;
                        document.getElementById('saleTable').innerHTML += row;
                    });
                } else {
                    console.error('Error: sales data is missing or invalid');
                }
            })
            .catch(error => console.error('Error fetching sales data:', error));
    </script>
@endsection
