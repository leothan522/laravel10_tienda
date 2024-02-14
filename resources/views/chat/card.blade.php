<div class="col-12" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="card card-primary card-outline direct-chat direct-chat-primary">

        <div class="card-header">
            <h3 class="card-title">Direct Chat</h3>
            <div class="card-tools">
                <button class="btn btn-tool" title="{{ $new }} Mensajes Nuevos" wire:click="show">
                    <i class="far fa-bell text-sm"></i>
                    @if($new > 0)
                        <span class="badge badge-warning navbar-badge font-weight-bold">{{ $new }}</span>
                    @endif
                </button>
            </div>
        </div>

        <div class="card-body">

            <!-- Conversations are loaded here -->
            <div class="direct-chat-messages" style="height:76vh;">

                <!-- Message. Default to the left -->
                <div class="direct-chat-msg">
                    <div class="direct-chat-infos clearfix">
                        <span class="direct-chat-name float-left">{{ config('app.name') }}</span>
                        <span class="direct-chat-timestamp float-right">{{ verFecha($fecha, 'd M h:i a') }}</span>
                    </div>
                    <img class="direct-chat-img" src="{{ asset('img/preloader_171x171.png') }}" alt="Message User Image">
                    <div class="direct-chat-text">
                        Bienvenido a nuestro <span class="text-navy text-bold">Chat Directo</span>. este chat es
                        @if(!$tipo)
                            <span class="text-success text-bold">Publico</span>
                        @else
                            <span class="text-primary text-bold">Privado</span>
                        @endif
                    </div>
                </div>
                <!-- /.direct-chat-msg -->

                @include('chat.show_messages')

            </div>
            <!--/.direct-chat-messages-->

        </div>

        <div class="card-footer">
            <form wire:submit="save">
                <div class="input-group">
                    {{--<input type="text" name="message" placeholder="Type Message ..." class="form-control">--}}
                    <textarea wire:model="mensaje" id="textarea_message" class="form-control" cols="1" rows="2" placeholder="Escriba el mensaje..."></textarea>
                    <span class="input-group-append">
                      <button type="submit" class="btn btn-primary" id="btn_chat_send_message">Send</button>
                    </span>
                </div>
                @error('mensaje')
                <span class="col-sm-12 text-sm text-bold text-danger">
                        <i class="icon fas fa-exclamation-triangle"></i>
                        {{ $message }}
                    </span>
                @enderror
            </form>
        </div>

        <div class="overlay-wrapper" wire:loading wire:target="save, show">
            <div class="overlay">
                <div class="spinner-border text-navy" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>

    </div>
</div>
