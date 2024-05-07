@extends('vendor.multishop.master')

@section('title', 'SPORTEC | Perfil')

@section('content')
    @include('web.multishop.perfil.content')
@endsection

@section('js')
    <script>
        console.log('Hi!')
    </script>
@endsection

@section('css')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@endsection

