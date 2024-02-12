@extends('vendor.multishop.master')

@section('title', mb_strtoupper(config('app.name')).' | Inicio')

@section('content')
    @livewire('web.home-component')
@endsection

@section('js')
    <script>
        Livewire.on('cerrarModalLogin', (nombre) => {
            setTopBar(nombre);
            $('#btn_modal_login_cerrar').click();
        });
        console.log('Hi!')
    </script>
@endsection

