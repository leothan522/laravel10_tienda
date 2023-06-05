@extends('adminlte::page')

@section('plugins.Select2', true)

@section('title', 'Cloud Messaging (FCM)')

@section('content_header')
    <h1><i class="fas fa-bell"></i> Firebase Cloud Messaging</h1>
@endsection

@section('content')
    @livewire('f-c-m.fcm-component')
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

        $('#fcm_token_users').select2({
            theme: 'bootstrap4',
            language: "es"
        })

        $('#fcm_token_users').on('change', function () {
            let token = $(this).val();
            Livewire.emit('tokenSeleccionado', token);
        });

        console.log('Hi!');
    </script>
@endsection
