@extends('vendor.multishop.master')

@section('title', 'SPORTEC | Inicio')

@section('content')
    @include('vendor.multishop.components.carousel.carousel')
    @include('vendor.multishop.components.featured.featured')
    @include('vendor.multishop.components.categories.categories')
    @include('vendor.multishop.components.products.products', ['products_title' => 'Productos Destacados'])
    @include('vendor.multishop.components.offer.offer')
    @include('vendor.multishop.components.products.products', ['products_title' => 'Productos recientes'])
    @include('vendor.multishop.components.vendor.vendor')
@endsection

@section('js')
    <script>
        console.log('Hi!')
    </script>
@endsection

