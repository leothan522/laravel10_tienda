@extends('vendor.multishop.master')

@section('title', 'SPORTEC | Inicio')

@section('content')

    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="#">Home</a>
                    <a class="breadcrumb-item text-dark" href="#">Shop</a>
                    <span class="breadcrumb-item active">Shop List</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Shop Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">

            <!-- Shop Sidebar Start -->
            @include('vendor.multishop.components.shop.sidebar')
            <!-- Shop Sidebar End -->

            <!-- Shop Product Start -->
            @include('vendor.multishop.components.shop.products')
            <!-- Shop Product End -->

        </div>
    </div>
    <!-- Shop End -->

@endsection

@section('js')
    <script>
        console.log('Hi!')
    </script>
@endsection
