@extends('layouts.adminlte')

@section('title')
    Chat Directo | {{ auth()->user()->name }}
@endsection

@section('content')
    @livewire('chat.chat-component')
@endsection

@section('css')
    {{--<link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">--}}
@endsection

@section('js')
    {{--<script src="../../dist/js/adminlte.min.js"></script>--}}
    <script>

        Livewire.on('downScroll', ({ i }) => {
            setTimeout(function () {
                let pageBottom = document.querySelector("#page-bottom_" + i);
                pageBottom.scrollIntoView();
            }, 500);
        });

        $('#textarea_message').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();

                // Ajax code here
                $('#btn_chat_send_message').click();

                return false;
            }
        });

        function refresh() {
            Livewire.dispatch('refresh');
        }

        $(document).ready(function () {
            setInterval(refresh, 5000);
        });

        console.log('Hi!')
    </script>
@endsection
