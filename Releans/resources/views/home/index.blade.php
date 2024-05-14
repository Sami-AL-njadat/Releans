@extends('layout.master')

@section('content')
    <div class="loader">
        <div class="loader-circle"></div>
        <div class="loader-img">
            <img src="{{ asset('front_end/img/core-img/pls.jpeg') }}" alt="" />
        </div>

    </div>

    @if (session()->has('error'))
        <script>
            alert('{{ session('error') }}');
        </script>
    @endif
    <!-- Your Blade template -->
    {{-- @if (session('error'))
        <script>
            // Extract the error message from the session data
            var errorMessage = {!! json_encode(session('error')) !!};

            alert(errorMessage.error);
        </script>
    @endif --}}

    <div class="main-content">
        <section class="section">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="shadow card card-statistic-2">

                        <div class="card-icon shadow-primary bg-primary">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Sales Report</h4>
                            </div>
                            <div class="card-body">
                                <a href="{{ route('sale.pdf') }}" class="btn btn-primary">Download Sales
                                    Report</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class=" shadow card card-statistic-2">

                        <div class="card-icon shadow-primary bg-primary">
                            <i class="fas fa-archive"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Popular Product </h4>
                            </div>
                            <div class="card-body">
                                <a href="{{ route('popular.pdf') }}" class="btn btn-primary">Download Popular Product
                                    Report
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class=" shadow card card-statistic-2">

                        <div class="card-icon shadow-primary bg-primary">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Inventory Report</h4>
                            </div>
                            <div class="card-body">
                                <a href="{{ route('inventory.pdf') }}" class="btn btn-primary">Download Inventory
                                    Report</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
