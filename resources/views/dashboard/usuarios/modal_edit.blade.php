<div wire:ignore.self class="modal fade" id="modal-user-edit" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="modal-dialog modal-lg">
        <div class="modal-content fondo">
            <div class="modal-header">
                {{--<h4 class="modal-title">Large Modal</h4>--}}
                <button type="button" wire:click="limpiar()" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row justify-content-center">
                    <div class="row col-md-11">

                        <div class="col-md-6">
                            <div class="card card-navy card-outline">
                                <div class="card-body box-profile">
                                    <div class="text-center">
                                        <img class="profile-user-img img-fluid img-circle" src="{{ verImagen($photo, true) }}" alt="User profile picture">
                                    </div>

                                    <h3 class="profile-username text-center">{{ ucwords($edit_name) }}</h3>

                                    {{--<p class="text-muted text-center">{!! iconoPlataforma($user->plataforma) !!}</p>--}}

                                    <ul class="list-group list-group-unbordered mb-3">
                                        <li class="list-group-item">
                                            <b>Email</b>
                                            <a class="float-right">
                                                {{ $edit_email }}
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Rol</b>
                                            <a class="float-right">
                                                {{ verRole($edit_role, $edit_roles_id) }}
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Estatus</b>
                                            <a class="float-right text-danger">
                                                {!! verEstatusUsuario($estatus) !!}
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Created_at</b>
                                            <a class="float-right">
                                                {{ verFecha($created_at) }}
                                            </a>
                                        </li>
                                        @if($edit_password)
                                            <li class="list-group-item">
                                                <b class="text-warning">Nueva Contraseña</b>
                                                <input type="text" wire:model.defer="edit_password" class="form-control col-sm-4 form-control-sm float-right"/>
                                            </li>
                                        @endif
                                    </ul>

                                    @if($edit_role != 100)
                                        <div class="row">
                                            <div class="col-md-6">
                                                @if ($estatus)
                                                    @php($clase = "btn-danger")
                                                    @php($texto = "Suspender Usuario")
                                                @else
                                                    @php($clase = "btn-success")
                                                    @php($texto = "Reactivar Usuario")
                                                @endif
                                                <button type="button" wire:click="cambiarEstatus({{ $usuarios_id }})" class="btn {{ $clase }} btn-block"
                                                        @if(!comprobarPermisos('usuarios.estatus')) disabled @endif>
                                                    <b>{{ $texto }}</b>
                                                </button>
                                            </div>
                                            <div class="col-md-6">
                                                <button type="button" wire:click="restablecerClave({{ $usuarios_id }})" class="btn btn-block btn-secondary"
                                                        @if(!comprobarPermisos('usuarios.password')) disabled @endif>
                                                    <b>Restablecer Contraseña</b>
                                                </button>
                                            </div>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">

                            <div class="card card-navy" style="height: inherit; width: inherit; transition: all 0.15s ease 0s;">

                                <div class="card-header">
                                    <h3 class="card-title">Editar Usuario</h3>
                                    <div class="card-tools">
                                        <button class="btn btn-tool text-bold" wire:click="edit({{ $usuarios_id }})">
                                            <i class="fas fa-redo"></i> Restablecer
                                        </button>
                                        {{--<span class="btn btn-tool"><i class="fas fa-user-edit"></i></span>--}}
                                    </div>
                                </div>

                                <div class="card-body">
                                    <form wire:submit.prevent="save">

                                        <div class="form-group">
                                            <label for="name">{{ __('Name') }}</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-user"></i>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control" wire:model.defer="edit_name" placeholder="Nombre y Apellido">
                                                @error('edit_name')
                                                <span class="col-sm-12 text-sm text-bold text-danger">
                                                    <i class="icon fas fa-exclamation-triangle"></i>
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="email">{{ __('Email') }}</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-envelope"></i>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control" wire:model.defer="edit_email" placeholder="Email">
                                                @error('edit_email')
                                                <span class="col-sm-12 text-sm text-bold text-danger">
                                                    <i class="icon fas fa-exclamation-triangle"></i>
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        @if($edit_role != 100)

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{ __('Role') }}</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-user-cog"></i>
                                                    </span>
                                                    </div>
                                                    <select class="custom-select" wire:model.defer="edit_role">
                                                        <option value="0">Estandar</option>
                                                        @foreach($listarRoles as $role)
                                                            <option
                                                                value="{{ $role->id }}">{{ ucwords($role->nombre) }}</option>
                                                        @endforeach
                                                        @if(comprobarPermisos())
                                                            <option value="1">Administrador</option>
                                                        @endif
                                                    </select>
                                                    @error('edit_role')
                                                    <span class="col-sm-12 text-sm text-bold text-danger">
                                                    <i class="icon fas fa-exclamation-triangle"></i>
                                                    {{ $message }}
                                                </span>
                                                    @enderror
                                                </div>
                                            </div>

                                        @endif

                                        <div class="form-group text-right">
                                            <input type="submit" class="btn btn-block btn-primary" value="Guardar Cambios">
                                        </div>

                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {!! verSpinner() !!}

            <div class="modal-footer row col-12 justify-content-between">
                <button type="button" class="btn btn-danger btn-sm" wire:click="destroy({{ $usuarios_id }})"
                        @if(!comprobarPermisos('usuarios.destroy') || !($edit_role != 1 || ($edit_role == 1 && comprobarPermisos())) || ($usuarios_id == auth()->id())) disabled @endif >
                    <i class="fas fa-trash-alt"></i>
                </button>
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal" wire:click="limpiar" id="button_edit_modal_cerrar">
                    {{ __('Close') }}
                </button>
            </div>

        </div>
    </div>
</div>
