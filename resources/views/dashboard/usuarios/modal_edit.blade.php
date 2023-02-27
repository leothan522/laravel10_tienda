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
                                        <img class="profile-user-img img-fluid img-circle"
                                             src="{{ verImagen($photo, true) }}" alt="User profile picture">
                                    </div>

                                    <h3 class="profile-username text-center">{{ ucwords($edit_name) }}</h3>

                                    {{--<p class="text-muted text-center">{!! iconoPlataforma($user->plataforma) !!}</p>--}}

                                    <ul class="list-group list-group-unbordered mb-3">
                                        <li class="list-group-item">
                                            <b>Email</b>
                                            <a class="float-right">{{ $edit_email }}</a>
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
                                                <input type="text" wire:model.defer="edit_password"
                                                       class="form-control col-sm-4 form-control-sm float-right"/>
                                            </li>
                                        @endif
                                    </ul>

                                    @if($edit_role != 100)
                                        <div class="row">
                                            <div class="col-md-6">
                                                @if ($estatus)
                                                    <button type="button" wire:click="cambiarEstatus({{ $usuario_id }})"
                                                            class="btn btn-danger btn-block"><b>Suspender Usuario</b>
                                                    </button>
                                                @else
                                                    <button type="button" wire:click="cambiarEstatus({{ $usuario_id }})"
                                                            class="btn btn-success btn-block"><b>Reactivar Usuario</b>
                                                    </button>
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                <button type="button" wire:click="restablecerClave({{ $usuario_id }})"
                                                        class="btn btn-block btn-secondary"><b>Restablecer Contraseña</b>
                                                </button>
                                            </div>
                                        </div>
                                    @endif

                                    {{--@if ($user_id && ((leerJson(Auth::user()->permisos, 'usuarios.update') ||
                                            Auth::user()->role == 1 || Auth::user()->role == 100) &&
                                            $user_id != Auth::user()->id))
                                    @endif--}}

                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">

                            <div class="card card-navy"
                                 style="height: inherit; width: inherit; transition: all 0.15s ease 0s;">

                                <div class="card-header">
                                    <h3 class="card-title">Editar Usuario</h3>
                                    <div class="card-tools">
                                        <button class="btn btn-tool text-bold" wire:click="edit({{ $usuario_id }})"><i class="fas fa-redo"></i> Restablecer</button>
                                        {{--<span class="btn btn-tool"><i class="fas fa-user-edit"></i></span>--}}
                                    </div>
                                </div>

                                <div class="card-body">


                                    <form wire:submit.prevent="save">

                                        <div class="form-group">
                                            <label for="name">{{ __('Name') }}</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
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
                                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
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

                                            @if($edit_role == 1)

                                                @if(auth()->user()->role == 1 || auth()->user()->role == 100)

                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">{{ __('Role') }}</label>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="fas fa-user-cog"></i></span>
                                                            </div>
                                                            <select class="custom-select" wire:model.defer="edit_role">
                                                                <option value="0">Estandar</option>
                                                                @foreach($roles as $role)
                                                                    <option value="{{ $role->id }}">{{ ucwords($role->nombre) }}</option>
                                                                @endforeach
                                                                @if(auth()->user()->role == 1 || auth()->user()->role ==100)
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

                                                @else

                                                @if($edit_role != auth()->user()->role)

                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">{{ __('Role') }}</label>
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text"><i class="fas fa-user-cog"></i></span>
                                                            </div>
                                                            <select class="custom-select" wire:model.defer="edit_role">
                                                                <option value="0">Estandar</option>
                                                                @foreach($roles as $role)
                                                                    <option value="{{ $role->id }}">{{ ucwords($role->nombre) }}</option>
                                                                @endforeach
                                                                @if(auth()->user()->role == 1 || auth()->user()->role ==100)
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

                                            @endif




                                            <div class="form-group text-right">
                                                <input type="submit" class="btn btn-block btn-success" value="Guardar">
                                            </div>

                                        @endif



                                    </form>


                                </div>


                            </div>

                            {{--<div class="card card-gray-dark">
                                <div class="card-header">
                                    <h5 class="card-title">Editar Usuario</h5>
                                    <div class="card-tools">
                                        <span class="btn btn-tool"><i class="fas fa-user-edit"></i></span>
                                    </div>
                                </div>
                                <div class="card-body">

                                    <form --}}{{--wire:submit.prevent="update({{ $user_id }})"--}}{{-->




                                        --}}{{--@if ($user_role != 100 && $user_id != Auth::user()->id)
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">{{ __('Role') }}</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-user-cog"></i></span>
                                                    </div>
                                                    <select name="role" class="custom-select" wire:model.defer="user_role">
                                                        --}}{{----}}{{--<option value="{{  }}">Seleccione</option>--}}{{----}}{{--
                                                        <option value="0">Estandar</option>
                                                        @foreach($roles as $rol)
                                                            <option value="{{ $rol->id }}">{{ ucwords($rol->nombre) }}</option>
                                                        @endforeach
                                                        @if(auth()->user()->role == 1 || auth()->user()->role ==100)
                                                            <option value="1">Administrador</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        @else
                                            <input type="hidden" name="role" value="--}}{{----}}{{--{{ $user->role }}--}}{{----}}{{--">
                                        @endif--}}{{--

                                        <div class="form-group text-right">
                                            <input type="hidden" name="mod" value="datos">
                                            <input type="submit" class="btn btn-block btn-primary" value="Guardar Cambios">
                                        </div>

                                    </form>

                                </div>
                            </div>--}}
                        </div>

                    </div>
                </div>


            </div>

            {!! verSpinner() !!}

            <div class="modal-footer justify-content-end">
                <button type="button" wire:click="limpiar()" class="btn btn-default btn-sm" data-dismiss="modal">{{ __('Close') }}</button>
            </div>


        </div>
    </div>
</div>
