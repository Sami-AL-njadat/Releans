@extends('page/login/layout/layout')

@section('content')
    @include('page/shop/page/navShop')
    <div class="main-content">
        <section class="section">
            <div class="row">
                <div class="col-12 col-sm-10 col-lg-10">
                    <div class="card">
                        <div class="card-header">
                            <h4>My Picture</h4>

                            <div class="card-header-action">

                                <div class="dropdown">


                                    <a href="{{ route('shop.page') }}">
                                        <button type="button" class="btn btn-primary btn-icon icon-right">

                                            <i class="fas fa-plane"></i> Back
                                        </button>
                                    </a>


                                </div>
                            </div>
                        </div>


                        <div class="row col-12">
                            <div class="col-8 card-body" id="product-details">

                            </div>
                            <div class="col-4 card-body ">
                                <form class="shadow p-5" id="formSelect" method="post">
                                    @csrf

                                    <div class="form-group">
                                        <label>Qantity</label>
                                        <input name="quantity" type="number" min="1" max="12000" step="1"
                                            autofocus class="form-control" required>


                                    </div>

                                    <div class="card-footer text-center">
                                        <button type="submit" class="btn btn-primary w-100"> Submit</button>
                                    </div>
                                </form>

                            </div>
                        </div>







                    </div>

                </div>
            </div>

        </section>
    </div>

    <script>
        var currentURL = window.location.href;
        var idProduct = currentURL.substr(currentURL.lastIndexOf('/') + 1);

        const url = `http://127.0.0.1:8000/api/selectProduct/${idProduct}`;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                const product = data.product;
                console.log(product);
                const badgeColor = product.status === 'in stock' ? 'primary' : 'warning';

                document.getElementById('product-details').innerHTML = `
                         <h5 class="card-title">${product.name}
                            <span  class="badge badge-${badgeColor}">${product.status} </span>
                            </h5>               

 
 <img style=" hight"110px !important; width:200px !important" src="${product.image}" class="img-fluid" alt="Product Image">
                         <h6  class="card-text mt-4">Price: ${product.price}</h6>
                         <h6  class="card-text ">Avilabel quantity: ${product.quantity}</h6>
                        <h6 class="card-text">Description: ${product.description}</h6>
                    </div>`;
            });
    </script>

    <script>
        var currentURL = window.location.href;
        var productId = currentURL.substr(currentURL.lastIndexOf('/') + 1);
        const formSelect = document.querySelector('#formSelect');
        formSelect.addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(formSelect);
            const quantity = formData.get('quantity');

            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(`http://127.0.0.1:8000/api/newSale/${productId}`, {
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
                    Swal.fire({
                        icon: "success",
                        title: "Order has been placed successfully,!!Wait for Accept please!!",
                        showConfirmButton: false,
                        timer: 4000
                    });

                    Swal.showLoading();
                    setTimeout(() => {
                        window.location.href = `http://127.0.0.1:8000/shop`;
                    }, 2000);
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: "warning",
                        title: "The quantity is not sufficient for this order. We'll need to try again at another time.",
                        showConfirmButton: false,
                        timer: 8000
                    });

                    Swal.showLoading();
                    setTimeout(() => {
                        window.location.href = `http://127.0.0.1:8000/shop`;
                    }, 2000);
                });
        });
    </script>
@endsection
