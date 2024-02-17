@extends('adminlte::page')

@section('plugins.Select2', true)

@section('title', 'Dashboard')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><i class="fas fa-boxes"></i> Stock</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{--<li class="breadcrumb-item"><a href="#">Home</a></li>--}}
                    <li class="breadcrumb-item active">Articulos con existencia</li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @livewire('dashboard.stock-old-component')
@endsection

@section('right-sidebar')
    @include('dashboard.stock.right-sidebarOld')
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

        function buscar() {
            let input = $("#navbarSearch");
            let keyword = input.val();
            if (keyword.length > 0) {
                input.blur();
                //alert('Falta vincular con el componente Livewire');
                $('.cargar_buscar').removeClass('d-none');
                Livewire.dispatch('buscar', {keyword: keyword});
            }
            return false;
        }

        function verAlmacenes() {
            Livewire.dispatch('limpiarAlmacenes');
        }

        function verTiposAjuste() {
            Livewire.dispatch('limpiarTiposAjuste');
        }

        function cambiarEmpresa() {
            Livewire.dispatch('changeEmpresa');
        }

        Livewire.on('verspinnerOculto', valor => {
            $('.cargar_buscar').removeClass('d-none');
        });

        $('#reportes_articulos').select2({
            theme: 'bootstrap4',
        });

        console.log('Hi!');
    </script>
@endsection
