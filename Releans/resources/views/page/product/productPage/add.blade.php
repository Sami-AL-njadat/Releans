@extends('layout.master')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Supplier</h1>
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
                                <h4>Add Product</h4>
                            </div>
                            <div class="card-body p-0">
                                <form method="POST" id="addProduct" enctype="multipart/form-data">
                                    @csrf

                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Name Of Product</label>
                                            <input name="name" type="text" class="form-control" required>

                                        </div>
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select name="status" class="form-control" required>
                                                <option value="" disabled selected>Select option</option>
                                                <option value="in stock">In Stock</option>
                                                <option value="out of stock">Out of Stock</option>
                                            </select>



                                        </div>

                                        <div class="form-group">
                                            <label>quantity</label>
                                            <input name="quantity" type="number" min="0" class="form-control"
                                                required>

                                        </div>


                                        <div class="form-group">
                                            <label>minimum level</label>
                                            <input name="minimum_level" type="number" min="0" class="form-control"
                                                required>

                                        </div>


                                        <div class="form-group">
                                            <label>Price</label>
                                            <input name="price" type="number" min="0" max="1000"
                                                step="1" class="form-control" required>

                                        </div>
                                        <div class="form-group">
                                            <label>image</label>
                                            <input id="image" name="image" type="file" class="form-control"
                                                required>
                                            <div class="col-xl-3">
                                                <div class="mb-3">
                                                    <img id="showImage" width="100px" src="">
                                                </div>

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
        addform = document.querySelector('#addProduct');
        addform.addEventListener('submit', function(event) {
            event.preventDefault();

            var formData = new FormData(addform);
            var name = formData.get('name');
            var status = formData.get('status');
            var quantity = formData.get('quantity');
            var price = formData.get('price');
            var description = formData.get('description');
            var image = formData.get('image');
            var minimum_level = formData.get('minimum_level');

            if (!name || !status || !quantity || !price || !description || !image) {
                alert("Please fill out all fields.");
                return;
            }

            if (isNaN(quantity) || isNaN(price) || isNaN(minimum_level)) {
                alert("Quantity and price must be numeric values.");
                return;
            }


            var ProductData = {
                name: name,
                status: status,
                quantity: quantity,
                price: price,
                description: description,
                image: image,
                minimum_level: minimum_level,

            };

            console.log('ProductData:', ProductData);
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch('http://127.0.0.1:8000/api/addproduct', {
                    method: 'post',
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


                    swal('Good Job', 'The Product Add Successful ', 'success')
                        .then(() => {
                            window.location.href = 'http://127.0.0.1:8000/product';
                        })
                })
                .catch(error => {
                    console.error('Error:', error);
                    swal('Error', 'You Enter Wrong Type of data! ', 'warning')
                        .then(() => {
                            window.location.href = 'http://127.0.0.1:8000/product';
                        })

                });

        });
    </script>

    <script>
        $(document).ready(function() {
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files[0]);
            })
        });
    </script>
@endsection
