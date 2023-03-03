<div class="card card-primary card-outline direct-chat direct-chat-primary" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="card-header">
        <h3 class="card-title">Chat Directo</h3>

        <div class="card-tools">

            @if($count_new > 0)
                <button title="{{ $count_new }} Nuevos Mensajes" class="btn btn-tool badge bg-primary" wire:click="verMessage">
                    {{ $count_new }}
                </button>
            @endif
            {{--<button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>--}}
            {{--<button type="button" class="btn btn-tool" title="Contactos" data-widget="chat-pane-toggle">
                <i class="fas fa-comments"></i>
            </button>--}}
            {{--<button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
            </button>--}}
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body" style="display: block;">
        <!-- Conversations are loaded here -->
        <div class="direct-chat-messages" style="height: 500px;">
            <!-- Message. Default to the left -->
            <div class="direct-chat-msg" id="scroll-to-bottom">
                <div class="direct-chat-infos clearfix">
                    <span class="direct-chat-name float-left">{{ config('app.name') }}</span>
                    <span
                        class="direct-chat-timestamp float-right">{{ verFecha($chat['created_at'], 'd M h:i a') }}</span>
                </div>
                <!-- /.direct-chat-infos -->
                <img class="direct-chat-img" src="{{ asset('img/logo.png') }}" alt="Message User Image">
                <!-- /.direct-chat-img -->
                <div class="direct-chat-text">
                    Bienvenido a nuestro <span class="text-navy text-bold">Chat Directo</span>. este chat es
                    @if($chat->tipo == 0) <span class="text-success text-bold">Publico</span> @else <span
                        class="text-primary text-bold">Privado</span> @endif
                </div>
                <!-- /.direct-chat-text -->
            </div>
            <!-- /.direct-chat-msg -->

        @foreach($messages as $message)
            <!-- Message to the right -->
                <div class="direct-chat-msg @if($message->users_id == auth()->id()) right @endif" id="page-bottom_{{ $message->id }}">
                    <div class="direct-chat-infos clearfix">
                        <span class="direct-chat-name @if($message->users_id == auth()->id()) float-right @endif">{{ ucwords($message->user->name) }}</span>
                        <span class="direct-chat-timestamp @if($message->users_id == auth()->id()) float-left @else float-right @endif">{{ verFecha($message->created_at, 'd M h:i a') }}</span>
                    </div>
                    <!-- /.direct-chat-infos -->
                    <img class="direct-chat-img" src="{{ verImagen($message->user->profile_photo_path, true) }}" alt="Message User Image">
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
                <input type="text" name="message" wire:model.defer="new_message" placeholder="Escriba el mensaje..." class="form-control">
                <span class="input-group-append">
                      <button type="submit" class="btn btn-primary">
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
</div>
