@extends('adminlte::page')

@section('plugins.Select2', true)

@section('title', 'Pagna de Prueba')

@section('content_header')
    {{--<h1>Pagina de Prueba</h1>--}}
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark"><i class="fas fa-boxes"></i> Pagina de Prueba</h1>
        </div>
        <div class="col-sm-6">
            {{--<ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Articulos con existencia</li>
            </ol>--}}
        </div>
    </div>
@stop

@section('content')
    <p>Welcome to this beautiful admin panel.</p>
@stop

@section('right-sidebar')
    @include('dashboard.right-sidebar')
@endsection

@section('footer')
    @include('dashboard.footer')
@stop

@section('css')
    {{--<link rel="stylesheet" href="/css/admin_custom.css">--}}
@stop

@section('js')
    <script src="{{ asset("js/app.js") }}"></script>
    <script>

        function buscar(){
            let input = $("#navbarSearch");
            let keyword  = input.val();
            if (keyword.length > 0){
                input.blur();
                alert('Falta vincular con el componente Livewire');
                //Livewire.dispatch('buscar', { keyword: keyword });
                $('#nabvar_cerrar_buscar').click();
            }
            return false;
        }

        console.log('Hi!');
    </script>
@stop
