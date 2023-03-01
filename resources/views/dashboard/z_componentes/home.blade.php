@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <p>Welcome to this beautiful admin panel.</p>
    <livewire:counter/>

    <br>
    <hr>
    @include('dashboard.z_componentes.vista_desde_array')

@stop

@section('footer')
    <div class="float-right d-none d-sm-block">
        <b>Version</b> 1.0
    </div>
    <strong>&copy; 2022 | {{ config('app.name') }}
        {{--| Ing. Yonathan Castillo.--}}
    </strong>
    {{--<em class="text-sm">
        Basado en <a href="http://adminlte.io" target="_blank">AdminLTE.io</a>.
    </em>--}}
@stop

@section('css')
    {{--<link rel="stylesheet" href="/css/admin_custom.css">--}}
@stop

@section('js')
    <script>

        $("#navbarSearch").focus(function () {
            let form = $(this).closest("form");
            form.attr("onsubmit", "return search()");
        });

        function search() {
            let input = $("#navbarSearch");
            let keyword = input.val();
            if (keyword.length > 0) {
                input.blur();
                Livewire.emit('increment', keyword);
            }
            return false;
        }

        console.log('Hi!');
    </script>
@stop
