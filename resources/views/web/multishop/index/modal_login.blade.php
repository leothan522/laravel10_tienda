<!-- Button trigger modal -->
{{--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
    Launch static backdrop modal
</button>--}}

<!-- Modal -->
<div wire:ignore.self class="modal fade" id="modal_login" data-backdrop="static" data-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form wire:submit="login">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel"></h5>
                    <h5 class="modal-title" id="staticBackdropLabel">Iniciar Sesión</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">

                        @error('login_validacion')
                        <div class="col-md-12">
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                {{ $message }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                        @enderror

                        <div class="col-md-8">

                            <div class="form-group">
                                <label for="name">{{ __('Email') }}</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input type="email" class="form-control" wire:model="login_email"
                                           placeholder="Ingrese su email">
                                    @error('login_email')
                                    <span class="col-sm-12 text-sm text-bold text-danger">
                                        <i class="icon fas fa-exclamation-triangle"></i>
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name">{{ __('Password') }}</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-unlock"></i></span>
                                    </div>
                                    <input type="password" class="form-control" wire:model="login_password"
                                           placeholder="Ingrese su clave">
                                    @error('login_password')
                                    <span class="col-sm-12 text-sm text-bold text-danger">
                                        <i class="icon fas fa-exclamation-triangle"></i>
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>


                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <div class="col-12 p-0">
                        <a href="{{ route('register') }}" class="btn btn-link" onclick="verCargando()">
                            <span class="d-none d-lg-inline-flex">Registrarse</span>
                            <i class="fas fa-user-plus d-lg-none"></i>
                        </a>
                        <button class="btn btn-primary float-right" type="button" wire:loading disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            CARGANDO...
                        </button>

                        <button type="submit" class="btn btn-primary float-right" wire:loading.remove>INICIAR SESIÓN
                        </button>

                        <button type="button" class="btn btn-secondary float-right mr-2" data-dismiss="modal"
                                wire:loading.remove id="btn_modal_login_cerrar">Cerrar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
