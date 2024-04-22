@extends('layout.master')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Stock Transaction</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Components</a></div>
                    <div class="breadcrumb-item">Table</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Edit Stock Transaction</h4>
                            </div>
                            <div class="card-body p-0">
                                <form id="editTrans">
                                    @csrf
                                    <input hidden name="id" type="text">
                                    <div class="card-body">


                                        <div class="form-group">
                                            <label>Product</label>
                                            <select name="product_id" class="form-control" required>
                                                <option value="" disabled selected>Select Product</option>

                                            </select>
                                        </div>



                                        <div class="form-group">
                                            <label>Type of Transaqtion</label>
                                            <select name="type" class="form-control" required>
                                                <option value="" disabled selected>Select option</option>
                                                <option value="addition">Addition</option>
                                                <option value="deduction">Deduction</option>
                                            </select>



                                        </div>
                                        <div class="form-group">
                                            <label>quantity</label>
                                            <input name="quantities" type="number" min="0" class="form-control"
                                                required>

                                        </div>



                                        <div class="form-group">
                                            <label>Resoun</label>
                                            <input name="reason" type="text" class="form-control" required>

                                        </div>


                                        <div class="form-group mb-0">
                                            <label>Description</label>
                                            <textarea name="description" class="form-control" required></textarea>

                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        var currentURL = window.location.href;
        var idstock = currentURL.substr(currentURL.lastIndexOf('/') + 1);

        const url = `http://127.0.0.1:8000/api/selectTrans/${idstock}`;
        fetch(url)
            .then(response => response.json())
            .then(data => {
                const transaction = data.stock;
                console.log(transaction, "www");

                fetch('http://127.0.0.1:8000/api/allProduct')
                    .then(response => response.json())
                    .then(productsData => {
                        if (productsData && Array.isArray(productsData.product) && productsData.product.length >
                            0) {
                            const productsMap = {};
                            productsData.product.forEach(product => {
                                productsMap[product.id] = product.name;
                            });

                            const productDropdown = document.querySelector('select[name="product_id"]');
                            productDropdown.innerHTML = '';

                            Object.keys(productsMap).forEach(productId => {
                                const option = document.createElement('option');
                                option.value = productId;
                                option.textContent = productsMap[productId];
                                if (productId === transaction.product_id.toString()) {
                                    option.selected =
                                        true;
                                }
                                productDropdown.appendChild(option);
                            });
                        } else {
                            console.error('Products data is empty or not in expected format');
                        }
                    })
                    .catch(error => console.error('Error fetching products:', error));

                document.querySelector('select[name="type"]').value = transaction.type;
                document.querySelector('input[name="quantities"]').value = transaction.quantities;
                document.querySelector('input[name="reason"]').value = transaction.reason;
                document.querySelector('textarea[name="description"]').value = transaction.description;
                document.querySelector('input[name="id"]').value = transaction
                    .id;
            })
            .catch(error => console.error('Error fetching transaction data:', error));
    </script>



    <script>
        var currentURL = window.location.href;
        var idstock = currentURL.substr(currentURL.lastIndexOf('/') + 1);

        fetch('http://127.0.0.1:8000/api/allProduct')
            .then(response => response.json())
            .then(data => {
                const selectElement = document.querySelector('select[name="product_id"]');
                if (Array.isArray(data.product)) {
                    data.product.forEach(product => {
                        const option = document.createElement('option');
                        option.value = product.id;
                        option.textContent = product.name;
                        selectElement.appendChild(option);
                    });
                } else {
                    console.error('Error: Product data is not an array');
                }
            })
            .catch(error => {
                console.error('Error fetching products:', error);
            });

        const stockTransForm = document.querySelector('#editTrans');
        stockTransForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const selectedProductId = stockTransForm.querySelector('select[name="product_id"]').value;

            const formData = new FormData(stockTransForm);
            formData.append('product_id', selectedProductId);
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(`http://127.0.0.1:8000/api/editTrans/${idstock}`, {
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
                    swal('Good Job', 'You clicked the button!', 'success')
                        .then(() => {
                            window.location.href = 'http://127.0.0.1:8000/stock';
                        })
                })
                .catch(error => {
                    console.error('Error:', error);
                    swal('Error', 'You Enter Wrong Type of data!', 'warning')
                        .then(() => {
                            window.location.href = 'http://127.0.0.1:8000/stock';
                        })

                });
        });
    </script>
@endsection
