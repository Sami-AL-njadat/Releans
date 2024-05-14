@extends('layout.master')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit product</h1>

            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>EDIT Product</h4>
                            </div>
                            <div class="card-body p-0">
                                <form id="editProduct" enctype="multipart/form-data">
                                    @csrf
                                    <input type="text" hidden name="id" value="">
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
                                                step="0.01" class="form-control" required>

                                        </div>
                                        <div class="form-group">
                                            <label>Image</label>
                                            <input id="image" name="image" type="file" class="form-control">

                                            <label>Image Old</label>
                                            <img id="imagePreview" src="" alt="Product Image"
                                                style="display: none; max-width: 200px; margin-top: 10px;">


                                        </div>
                                        <div class="form-group">
                                            <label>Image New</label>
                                            <img id="imagenew" width="200px" src="">

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
        var idProduct = currentURL.substr(currentURL.lastIndexOf('/') + 1);

        const url = `http://127.0.0.1:8000/api/selectProduct/${idProduct}`;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                const product = data.product;
                console.log(product);

                document.querySelector('input[name="id"]').value = product.id;
                document.querySelector('input[name="name"]').value = product.name;
                document.querySelector('select[name="status"]').value = product.status;
                document.querySelector('input[name="quantity"]').value = product.quantity;
                document.querySelector('input[name="minimum_level"]').value = product.minimum_level;
                document.querySelector('input[name="price"]').value = product.price;
                document.querySelector('textarea[name="description"]').value = product.description;

                if (product.image) {
                    const imagePreview = document.getElementById('imagePreview');
                    imagePreview.src = `http://127.0.0.1:8000/${product.image}`;
                    imagePreview.style.display = 'block';
                }
            })
            .catch(error => console.error('Error fetching product data:', error));
    </script>

    <script>
        const editForm = document.getElementById('editProduct');

        editForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const productId = document.querySelector('input[name="id"]').value;

            const name = document.querySelector('input[name="name"]').value;
            const status = document.querySelector('select[name="status"]').value;
            const quantity = document.querySelector('input[name="quantity"]').value;
            const minimum_level = document.querySelector('input[name="minimum_level"]').value;
            const price = document.querySelector('input[name="price"]').value;
            const description = document.querySelector('textarea[name="description"]').value;
            const image = document.querySelector('input[name="image"]').files[0];

            const isModified = name || status || quantity || minimum_level || price || description || image;

            if (!isModified) {
                console.log("sss", isModified);
                window.location.href = 'http://127.0.0.1:8000/product';
                return;
            }

            const formData = new FormData();
            formData.append('id', productId);
            formData.append('name', name);
            formData.append('status', status);
            formData.append('quantity', quantity);
            formData.append('minimum_level', minimum_level);
            formData.append('price', price);
            formData.append('description', description);
            if (image) {
                formData.append('image', image);
            }
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(`http://127.0.0.1:8000/api/editProduct/${productId}`, {
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
                    swal('Good Job', 'You clicked the button!', 'success')
                        .then(() => {
                            window.location.href = 'http://127.0.0.1:8000/product';
                        })
                })
                .catch(error => {
                    console.error('Error:', error);

                    swal('Error', 'You Enter Wrong Type of data!', 'warning')
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
                    $('#imagenew').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files[0]);
            })
        });
    </script>
@endsection
