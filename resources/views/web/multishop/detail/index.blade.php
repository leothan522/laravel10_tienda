@extends('vendor.multishop.master')

@section('title', 'SPORTEC | Ver Detalles')

@section('content')

    @livewire('web.detail-component', ['stock_id' => $stock_id])

@endsection

@section('js')
    <script>

        Livewire.on('cerrarModalLogin', ({ nombre }) => {
            setTopBar(nombre);
            $('#btn_modal_login_cerrar').click();
        });

        /*$(document).ready(function(){
            //Código que se ejecutará al cargar la página
            let pageBottom = document.querySelector("#breadcrumb");
            pageBottom.scrollIntoView();
        });*/

        console.log('Hi!')
    </script>
@endsection
