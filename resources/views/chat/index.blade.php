@extends('layouts.adminlte')

@section('title')
    Chat Directo
@endsection

@section('content')
    @livewire('chat.chat-component')
@endsection

@section('css')
    {{--<link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">--}}
    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
@endsection

@section('js')
    {{--<script src="../../dist/js/adminlte.min.js"></script>--}}
    <script !src="">
        Livewire.on('bajarScroll', idMessage =>{
            let scrollToBottom = document.querySelector("#scroll-to-bottom");
            let pageBottom = document.querySelector("#page-bottom_" + idMessage);
            pageBottom.scrollIntoView();
        });
        function refresh()
        {
            Livewire.emit('refresh');
        }
        $(document).ready(function () {
           setInterval(refresh, 5000);
        });

        console.log('Hi!')
    </script>
@endsection
