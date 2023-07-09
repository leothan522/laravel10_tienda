@extends('vendor.multishop.master')

@section('title', 'SPORTEC | Inicio')

@section('content')

@livewire('web.shop-component', [
    'view' => $view,
    'shop_id' => $shop_id
    ])

@endsection

@section('js')
    <script>
        Livewire.on('cerrarModalLogin', (nombre) => {
            setTopBar(nombre);
            $('#btn_modal_login_cerrar').click();
        });
        Livewire.on('cerrarCargando', () => {
            cerrarCargando();
        });
        console.log('Hi!')
    </script>
@endsection
