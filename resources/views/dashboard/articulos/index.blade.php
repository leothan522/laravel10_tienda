@extends('adminlte::page')

@section('plugins.Select2', true)

@section('title', 'Dashboard')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><i class="fas fa-box"></i> Artículos</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{--<li class="breadcrumb-item"><a href="#">Home</a></li>--}}
                    <li class="breadcrumb-item active">Artículos Registrados</li>
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

        function verCategorias() {
                Livewire.dispatch('limpiarCategorias');
        }

        function verUnidades() {
            Livewire.dispatch('limpiarUnidades');
        }

        function verTributarios() {
            Livewire.dispatch('limpiarTributarios');
        }

        function verProcedencias() {
            Livewire.dispatch('limpiarProcedencias');
        }

        function verTipos() {
            Livewire.dispatch('limpiarTipos');
        }

        function imgCategoria() {
            $('#customFileLangCategoria').click();
        }

        function select_2(id, data, opcion)
        {
            $('#'  + id).select2({
                theme: 'bootstrap4',
                data: data,
                placeholder: 'Seleccione'
            });
            $('#'  + id).val(null).trigger('change');
            $('#'  + id).on('change', function() {
                var val = $(this).val();
                switch (opcion) {
                    case 0:
                        Livewire.dispatch('tipoSeleccionado', { id: val });
                    break;
                    case 1:
                        Livewire.dispatch('categoriaSeleccionada', { id: val });
                    break;
                    case 2:
                        Livewire.dispatch('procedenciaSeleccionada', { id: val });
                    break;
                    case 3:
                        Livewire.dispatch('tributoSeleccionado', { id: val });
                    break;
                    case 4:
                        Livewire.dispatch('unidadSeleccionada', { id: val });
                    break;
                    case 5:
                        Livewire.dispatch('secundariaSeleccionada', { id: val });
                    break;
                    case 6:
                        Livewire.dispatch('empresaSeleccionada', { id: val });
                    break;
                }
            });
        }

        Livewire.on('setSelectFormArticulos', ({ tipos, categorias, procedencias, tributarios }) => {
            select_2('select_articulos_tipos', tipos, 0);
            select_2('select_articulos_categorias', categorias, 1);
            select_2('select_articulos_procedencias', procedencias, 2);
            select_2('select_articulos_tributarios', tributarios, 3);
        });

        function selectEditar(id, valor)
        {
            $("#" + id).val(valor);
            $("#" + id).trigger('change');
        }

        Livewire.on('setSelectFormEditar', ({ tipos, categorias, procedencias, tributarios }) => {
            selectEditar('select_articulos_tipos', tipos);
            selectEditar('select_articulos_categorias', categorias);
            selectEditar('select_articulos_procedencias', procedencias);
            selectEditar('select_articulos_tributarios', tributarios);
        });

        Livewire.on('setSelectFormUnidades', ({ unidades }) =>{
            select_2('select_articulos_unidades', unidades, 4);
            select_2('select_unidades_artund', unidades, 5);
        });

        Livewire.on('setSelectFormEditUnd', ({ unidades }) =>{
            $('#select_articulos_unidades').val(unidades);
            $('#select_articulos_unidades').trigger('change');
        });

        Livewire.on('setSelectFormEmpresas', ({ empresas }) => {
            select_2('select_precios_empresas', empresas, 6)
        });

        Livewire.on('setSelectPrecioEmpresas', ({ empresas }) => {
            $('#select_precios_empresas').val(empresas);
            $('#select_precios_empresas').trigger('change');
        });

        function imgPrincipal()
        {
            $('#customFileLang').click();
        }

        function imgGaleria(i)
        {
            let input = document.getElementById('img_Galeria_' + i);
            input.click();
        }

        function buscar(){
            let input = $("#navbarSearch");
            let keyword  = input.val();
            if (keyword.length > 0){
                input.blur();
                //alert('Falta vincular con el componente Livewire');
                $('.cargar_buscar').removeClass('d-none');
                Livewire.dispatch('buscar', { keyword: keyword });
            }
            return false;
        }

        console.log('Hi!');
    </script>
@endsection
