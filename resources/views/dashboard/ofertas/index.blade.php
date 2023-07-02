@extends('adminlte::page')

@section('plugins.Select2', true)

@section('title', 'Ofertas')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><i class="fas fa-gifts"></i> Ofertas</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{--<li class="breadcrumb-item"><a href="#">Home</a></li>--}}
                    <li class="breadcrumb-item active">Descuentos Especiales</li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @livewire('dashboard.ofertas-component')
@endsection

@section('right-sidebar')
    @include('dashboard.right-sidebar')
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

        function cambiarEmpresa()
        {
            Livewire.emit('changeEmpresa');
        }

        $('#select_categorias').select2({
            theme: 'bootstrap4',
            placeholder: 'Seleccione',
            language: "es"
        });

        $('#select_articulos').select2({
            theme: 'bootstrap4',
            placeholder: 'Seleccione',
            language: "es"
        });

        $('#select_categorias').on('change', function () {
            var val = $(this).val();
            Livewire.emit('categoriaSeleccionada', val);
        });

        $('#select_articulos').on('change', function () {
            var val = $(this).val();
            Livewire.emit('articuloSeleccionado', val);
        });

        Livewire.on('setEdit', (categoria, articulo) => {
            $('#select_categorias').val(categoria).trigger('change');
            $('#select_articulos').val(articulo).trigger('change');
        });


        console.log('Hi!');
    </script>
@endsection
