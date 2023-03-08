@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><i class="fas fa-box"></i> Articulos</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{--<li class="breadcrumb-item"><a href="#">Home</a></li>--}}
                    <li class="breadcrumb-item active">Articulos Registrados</li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @livewire('dashboard.articulos-component')
@endsection

@section('right-sidebar')
    @include('dashboard.articulos.right-sidebar')
@endsection

@section('footer')
    @include('dashboard.footer')
@endsection

@section('css')
    {{--<link rel="stylesheet" href="/css/admin_custom.css">--}}
@stop

@section('js')
    <script src="{{ asset("js/app.js") }}"></script>
    <script>

        function search(){
            let input = $("#navbarSearch");
            let keyword  = input.val();
            if (keyword.length > 0){
                input.blur();
                alert('Falta vincular con el componente Livewire');
                //Livewire.emit('increment', keyword);
            }
            return false;
        }

        function verCategorias() {
                Livewire.emit('limpiarCategorias');
        }

        function verUnidades() {
            Livewire.emit('limpiarUnidades');
        }

        function verTributarios() {
            Livewire.emit('limpiarTributarios');
        }

        console.log('Hi!');
    </script>
@endsection
