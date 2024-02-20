@extends('adminlte::page')

@section('plugins.Select2', true)

@section('title', 'Pagna de Prueba')

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
@stop

@section('content')
    {{--<p>Welcome to this beautiful admin panel.</p>--}}
    @livewire('dashboard.mount-empresas-component')
    <div>
        @livewire('dashboard.articulos-component')
    </div>
    <div class="row">
        @livewire('dashboard.categorias-component')
        @livewire('dashboard.unidades-component')
        @livewire('dashboard.procedencias-component')
        @livewire('dashboard.tributarios-component')
        @livewire('dashboard.tipos-component')
    </div>

@stop

@section('right-sidebar')
    @include('dashboard.articulos.right-sidebar')
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

        function verCategorias() {
            Livewire.dispatch('limpiarCategorias');
        }

        function imgCategoria() {
            $('#customFileLangCategoria').click();
        }

        function verUnidades() {
            Livewire.dispatch('limpiarUnidades');
        }

        function verProcedencias() {
            Livewire.dispatch('limpiarProcedencias');
        }

        function verTributarios() {
            Livewire.dispatch('limpiarTributarios');
        }

        function verTipos() {
            Livewire.dispatch('limpiarTipos');
        }

        function verSpinnerOculto() {
            $('.cargar_articulos').removeClass('d-none');
        }

        $(document).ready(function () {
            verSpinnerOculto();
            Livewire.dispatch('updatedEmpresaID');
        });

        function changeEmpresa() {
            $('.cargar_articulos').removeClass('d-none');
        }

        function select_2(id, data, evento, icono = 'far fa-bookmark')
        {
            let html = '<div class="input-group-prepend">';
            html += '<span class="input-group-text">';
            html += '<i class="' + icono + '"></i>';
            html += '</span>';
            html += '</div>';
            html += '<select id="' + id + '"></select>';
            $('#div_' + id).html(html);

            $('#' + id).select2({
                theme: 'bootstrap4',
                data: data,
                placeholder: 'Seleccione'
            });
            $('#' + id).val(null).trigger('change');
            $('#' + id).on('change', function () {
                var val = $(this).val();
                Livewire.dispatch(evento, {id: val});
            });
        }

        function selectEditar(id, valor) {
            $("#" + id).val(valor);
            $("#" + id).trigger('change');
        }

        Livewire.on('selectFormArticulos', ({id, data, evento, icono }) => {
            select_2(id, data, evento, icono);
        });

        Livewire.on('setSelectFormArticulos', ({id, valor}) => {
            selectEditar(id, valor)
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

        function verArticulosUnidad()
        {
            $('.cargar_ArtUnd').removeClass('d-none');
        }

        Livewire.on('clickBtnUnidad', () => {
            setTimeout(function () {
                $('#button_card_view_unidad').click();
            }, 500);
        });

        Livewire.on('setUnd', ({ id }) => {
            setTimeout(function () {
                $('#unidades_select_unidad')
                    .val(id)
                    .trigger('change');
            }, 500);
        });

        function verArticulosPrecios()
        {
            $('.cargar_precio').removeClass('d-none');
        }

        Livewire.on('setUnidad', ({ id }) => {
            setTimeout(function () {
                $('#precios_select_unidades')
                    .val(id)
                    .trigger('change');
            }, 500);
        });

        function verArticulosIdentificadores()
        {
            $('.cargar_indentificador').removeClass('d-none');
        }


        /*function buscar() {
            let input = $("#navbarSearch");
            let keyword = input.val();
            if (keyword.length > 0) {
                input.blur();
                alert('Falta vincular con el componente Livewire');
                //Livewire.dispatch('buscar', { keyword: keyword });
                $('#nabvar_cerrar_buscar').click();
            }
            return false;
        }*/

        console.log('Hi!');
    </script>
@stop
