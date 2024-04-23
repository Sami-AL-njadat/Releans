@extends('page/login/layout/layout')

@section('content')
    @include('page/shop/page/navShop')
    <div style="     padding-left: 120px;
 !important" class="main-content">
        <section class="section">

            <div class="card  p-3">

                <h1>Shop</h1>
                <h2 class="section-title  ">Welcome here </h2>
                <p class="section-lead">
                    Enjoy
                </p>
                <div id="sortableCard" class="row sortable-card"></div>


                <div class="row sortable-card">


                </div>
            </div>

        </section>
    </div>

    <script>
        fetch('http://127.0.0.1:8000/api/allProduct')
            .then(response => response.json())
            .then(data => {
                if (data && data.product) {
                    data.product.forEach(product => {
                        const badgeColor = product.status === 'in stock' ? 'primary ' : 'warning';

                        const card = `
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="shadow card    p-2"  >
                            <div class="card-header">
<img style="border-radius: 120%;
    width: 91px;padding:10px ;
    height: 80px;" src="${product.image}" alt="">            
                        <h4>${product.name}</h4>
                            </div>
                            <div class="card-body">

                                <span class="badge badge-${badgeColor}">Status: ${product.status}</span>
                                <p>Price: ${product.price}</p>
                                <p>Description: ${product.description}</p>
                            </div>
            ${product.status !== 'out of stock' ? `<a href="{{ route('select.page', ['id' => '']) }}/${product.id}" class="btn btn-info" onclick="selectProduct(${product.id})">Select</a>` : `<button class="btn btn-warning disabled">Out of Stock</button>`}
                        </div>
                    </div>`;
                        document.getElementById('sortableCard').innerHTML += card;
                    });
                } else {
                    console.error('Error: Products data is missing or invalid');
                }
            })
            .catch(error => console.error('Error fetching product data:', error));
    </script>
@endsection
