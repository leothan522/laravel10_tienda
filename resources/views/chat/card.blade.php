<div class="card card-primary card-outline direct-chat direct-chat-primary" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="card-header">
        <h3 class="card-title col-12">
            <span>Chat Directo2</span>
            <span class="float-right">
                <a class="nav-link" wire:click="verMessage" data-mensaje_id="{{ $ultimo_mensaje }}" data-coutn_new="{{ $count_new }}"
                   style="cursor: pointer" id="ultimo_mensaje_abrir">
                    <i class="far fa-bell text-sm"></i>
                    @if($count_new > 0)
                        <span class="badge badge-warning navbar-badge font-weight-bold">{{ $count_new }}</span>
                    @endif
                </a>
            </span>
        </h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body" style="display: block;">
        <!-- Conversations are loaded here -->
        <div class="direct-chat-messages" style="height:76vh;">
            <!-- Message. Default to the left -->
            <div class="direct-chat-msg" id="scroll-to-bottom">
                <div class="direct-chat-infos clearfix">
                    <span class="direct-chat-name float-left">{{ config('app.name') }}</span>
                    <span class="direct-chat-timestamp float-right">{{ verFecha($chat['created_at'], 'd M h:i a') }}</span>
                </div>
                <!-- /.direct-chat-infos -->
                <img class="direct-chat-img" src="{{ asset('img/preloader_171x171.png') }}" alt="Message User Image">
                <!-- /.direct-chat-img -->
                <div class="direct-chat-text">
                    Bienvenido a nuestro <span class="text-navy text-bold">Chat Directo</span>. este chat es
                    @if($chat->tipo == 0)
                        <span class="text-success text-bold">Publico</span>
                    @else
                        <span class="text-primary text-bold">Privado</span>
                    @endif
                </div>
                <!-- /.direct-chat-text -->
            </div>
            <!-- /.direct-chat-msg -->

            <input type="hidden" id="page-bottom_0">
            @foreach($messages as $message)
                <!-- Message to the right -->
                <div class="direct-chat-msg @if($message->users_id == auth()->id()) right @endif"
                     id="page-bottom_{{ $message->id }}">
                    <div class="direct-chat-infos clearfix">
                        <span class="direct-chat-name @if($message->users_id == auth()->id()) float-right @endif">{{ ucwords($message->user->name) }}</span>
                        <span class="direct-chat-timestamp @if($message->users_id == auth()->id()) float-left @else float-right @endif"><span
                                    class="time"><i
                                        class="fas fa-clock"></i> {{ haceCuanto($message->created_at) }}</span></span>
                    </div>
                    <!-- /.direct-chat-infos -->
                    <img class="direct-chat-img" src="{{ verImagen($message->user->profile_photo_path, true) }}"
                         wire:click="showModal({{ $message->users_id }})"
                         alt="Message User Image" data-toggle="modal" data-target="#exampleModal"
                         style="cursor: pointer;">
                    <!-- /.direct-chat-img -->
                    <div class="direct-chat-text">
                        {{ $message->message }}
                    </div>
                    <!-- /.direct-chat-text -->
                </div>
                <!-- /.direct-chat-msg -->
            @endforeach


        </div>
        <!--/.direct-chat-messages-->

        <!-- Contacts are loaded here -->
        <div class="direct-chat-contacts">
            <ul class="contacts-list">
                <li>
                    <a href="#">
                        <img class="contacts-list-img" src="{{ verImagen(null, true) }}" alt="User Avatar">

                        <div class="contacts-list-info">
                          <span class="contacts-list-name">
                            Count Dracula
                            <small class="contacts-list-date float-right">2/28/2015</small>
                          </span>
                            <span class="contacts-list-msg">How have you been? I was...</span>
                        </div>
                        <!-- /.contacts-list-info -->
                    </a>
                </li>
                <!-- End Contact Item -->
            </ul>
            <!-- /.contatcts-list -->
        </div>
        <!-- /.direct-chat-pane -->
    </div>
    <!-- /.card-body -->
    <div class="card-footer" style="display: block;">
        <form wire:submit.prevent="save">
            <div class="input-group">
                {{--<input type="text" name="message" wire:model.defer="new_message" placeholder="Escriba el mensaje..." class="form-control">--}}
                <textarea name="message" wire:model.defer="new_message" class="form-control" cols="1" rows="2"
                          placeholder="Escriba el mensaje..." id="textarea_message"></textarea>
                <span class="input-group-append">
                      <button type="submit" class="btn btn-primary" id="btn_subtmit_chat">
                          Enviar
                          {{--<div class="spinner-border spinner-border-sm" role="status" wire:loading>
                              <span class="sr-only">Loading...</span>
                          </div>--}}
                      </button>
                </span>
            </div>
            @error('new_message')
            <span class="col-sm-12 text-sm text-bold text-danger">
                <i class="icon fas fa-exclamation-triangle"></i>
                {{ $message }}
            </span>
            @enderror
        </form>
    </div>
    <!-- /.card-footer-->
    <div class="overlay-wrapper" wire:loading wire:target="save, verMessage">
        <div class="overlay">
            <div class="spinner-border text-navy" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
</div>

