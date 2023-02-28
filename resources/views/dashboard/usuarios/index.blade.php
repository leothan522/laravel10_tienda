@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><i class="fas fa-users"></i> Usuarios</h1>
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

        $("#from_rol").submit(function(e) {
            e.preventDefault();
            let nombre = document.getElementById("nuevo_rol");
            Livewire.emit('saveRol', nombre.value);
        });

        Livewire.on('addRolList', (idRol, nombreRol) => {
            let input = document.getElementById("nuevo_rol");
            input.value = null;
            input.blur();
            let boton = '<button type="button" ' +
                'class="btn btn-primary btn-sm btn-block m-1" ' +
                'data-toggle="modal" data-target="#modal-user-permisos" ' +
                'class="btn btn-info btn-sm" ' +
                'onclick="verRoles(' +  idRol + ')" id="set_rol_id_' + idRol + '">' +  nombreRol + ' </button>';
            $('#listar_roles').append(boton);
        });

        Livewire.on('setRolList', (idRol, nombreRol) => {
            let boton = document.getElementById('set_rol_id_' + idRol);
            boton.innerText = nombreRol;
        });

        Livewire.on('removeRolList', idRol =>{
            let boton = document.getElementById("set_rol_id_" + idRol);
            let cerrar = document.getElementById('boton_rol_modal_cerrar');
            boton.classList.add("d-none");
            cerrar.click();
        });

        function verRoles(id){
            Livewire.emit('verPermisos', 'parametros', id);
        }

        console.log('Hi!');
    </script>
@endsection
