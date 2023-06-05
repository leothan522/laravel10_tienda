@extends('layouts.adminlte')

@section('title')
    Chat Directo | {{ auth()->user()->name }}
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
        Livewire.on('bajarScroll', idMessage => {
            let scrollToBottom = document.querySelector("#scroll-to-bottom");
            let pageBottom = document.querySelector("#page-bottom_" + idMessage);
            pageBottom.scrollIntoView();
        });

        function refresh() {
            Livewire.emit('refresh');
        }

        $(document).ready(function () {
            let html = '<div class="col-12 text-center mt-3"><span class="text-sm text-muted link-black"><i class="far fa-comments mr-1"></i> Nuevos </span> </div>';
            let elemento = document.getElementById('ultimo_mensaje_abrir');
            let ultimo = elemento.dataset.mensaje_id;
            let coutn_new = elemento.dataset.coutn_new;
            if (coutn_new > 0){
                $("#page-bottom_" + ultimo).append(html);
            }
            let scrollToBottom = document.querySelector("#scroll-to-bottom");
            let pageBottom = document.querySelector("#page-bottom_" + ultimo);
            pageBottom.scrollIntoView();
            setInterval(refresh, 5000);
        });

        $('#textarea_message').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();

                // Ajax code here
                $('#btn_subtmit_chat').click();

                return false;
            }
        });


        console.log('Hi!')
    </script>
@endsection
