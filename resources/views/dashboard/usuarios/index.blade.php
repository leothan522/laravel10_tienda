@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><i class="fas fa-users-cog"></i> Usuarios</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{--<li class="breadcrumb-item"><a href="#">Home</a></li>--}}
                    <li class="breadcrumb-item active">Usuarios Registrados</li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @livewire('dashboard.usuarios-component')
    @livewire('dashboard.roles-component')
@endsection

{{--@section('right-sidebar')
    @include('dashboard.right-sidebar')
@endsection--}}

@section('footer')
    @include('dashboard.footer')
@endsection

@section('css')
    {{--<link rel="stylesheet" href="/css/admin_custom.css">--}}
@stop

@section('js')
    <script src="{{ asset("js/app.js") }}"></script>
    <script>

        $("#from_role_usuario").submit(function(e) {
            e.preventDefault();
            let nombre = $('#input_role_nombre').val();
            Livewire.emit('save', nombre);
        });

        Livewire.on('addRolList', (id, nombre, rows) => {
            $('#input_role_nombre')
                .val('')
                .blur();
            let boton = '';
            boton += '<button type="button" class="btn btn-primary btn-sm btn-block m-1" data-toggle="modal"';
            boton += 'data-target="#modal-roles-usuarios" onclick="showRol(\'' + id + '\')" id="button_role_id_' + id + '" >';
            boton += nombre;
            boton += '</button>';

            $('#div_listar_roles').append(boton);
            $('#span_roles_rows').text(rows);
        });

        function showRol(id){
            $('#div_ver_spinner_roles').removeClass('d-none');
            Livewire.emit('edit', id);
        }

        Livewire.on('setRolList', (id, nombre) => {
            $('#button_role_id_' + id).text(nombre);
        });

        Livewire.on('removeRolList', id =>{
            Livewire.emit('limpiar');
            $('#button_role_id_' + id).addClass('d-none');
            $('#button_rol_modal_cerrar').click();
        });

        Livewire.on('cerrarModal', () => {
            $('#button_edit_modal_cerrar').click();
        });

        $('#button_rol_modal_cerrar').click(function (e) {
            $('#div_ver_spinner_roles').removeClass('d-none');
        });

        $('#button_permisos_modal_cerrar').click(function (e) {
            $('#div_ver_spinner_usuarios').removeClass('d-none');
        });

        console.log('Hi!');
    </script>
@endsection
