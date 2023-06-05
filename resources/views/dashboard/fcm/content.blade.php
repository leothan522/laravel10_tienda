<div class="row justify-content-center" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="col-4">
        <div class="card card-navy" style="height: inherit; width: inherit; transition: all 0.15s ease 0s;">
        <div class="card-header">
                <h3 class="card-title">
                    Firebase Cloud Messaging (FCM)
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" {{--wire:click="limpiar"--}}>
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <form wire:submit.prevent="sendMessage">

                    <div class="form-group">
                        <label for="name">Tipo FCM</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-paper-plane"></i></span>
                            </div>
                            <select class="custom-select" wire:model.defer="fcm_tipo">
                                <option value="">Seleccione...</option>
                                <option value="notification">With Notification</option>
                                <option value="data">With Data</option>
                            </select>
                            @error('fcm_tipo')
                            <span class="col-sm-12 text-sm text-bold text-danger">
                                <i class="icon fas fa-exclamation-triangle"></i>
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name">Titulo</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-window-maximize"></i></span>
                            </div>
                            <input type="text" class="form-control" wire:model.defer="title" placeholder="Titulo para la Notificación">
                            @error('title')
                            <span class="col-sm-12 text-sm text-bold text-danger">
                            <i class="icon fas fa-exclamation-triangle"></i>
                            {{ $message }}
                        </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name">Contenido</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-envelope-open-text"></i></span>
                            </div>
                            <input type="text" class="form-control" wire:model.defer="body" placeholder="Mensaje para la Notificación">
                            @error('body')
                            <span class="col-sm-12 text-sm text-bold text-danger">
                            <i class="icon fas fa-exclamation-triangle"></i>
                            {{ $message }}
                        </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name">FCM TOKEN</label>
                        <div class="input-group mb-3" wire:ignore>
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                            </div>
                            <select id="fcm_token_users">
                                <option value="todos">Enviar a Todos</option>
                                @if(!$listarUsers->isEmpty())
                                    @foreach($listarUsers as $user)
                                        <option value="{{ $user->fcm_token }}">{{ ucfirst($user->name) }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        @error('fcm_token')
                        <span class="col-sm-12 text-sm text-bold text-danger">
                            <i class="icon fas fa-exclamation-triangle"></i>
                            {{ $message }}
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-block btn-success" value="Guardar">
                    </div>

                </form>

                <!-- /.card-body -->
            </div>

            {!! verSpinner() !!}

        </div>
    </div>
</div>