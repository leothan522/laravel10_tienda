<div wire:ignore.self class="modal fade" id="modal-user-permisos" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    @if($tabla == "parametros")
                        Rol de usuario [ <span class="text-bold">{{ ucwords($tabla_nombre )}}</span> ]
                    @else
                        Permisos de Usuario
                        [ <span class="text-bold">{{ ucwords($tabla_nombre )}}</span> ]
                        [ <span class="text-bold">{{ ucwords($tabla_email )}}</span> ]
                    @endif
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                @include('dashboard.usuarios.verPermisos')

            </div>
            <div class="modal-footer">

                <div class="row col-md-12">
                    <div class="col-md-4">
                        <span>
                            Precio Dolar
                            <div class="custom-control custom-switch custom-switch-on-success float-left">
                                <input type="checkbox" wire:click="updatePermisos({{ $tabla_id }}, 'precio.dolar')"
                                       @if(leerJson($tabla_permisos, 'precio.dolar')) checked @endif
                                class="custom-control-input" id="customSwitch_dollar">
                                <label class="custom-control-label" for="customSwitch_dollar" role="button"></label>
                            </div>
                        </span>
                    </div>
                    <div class="col-md-8">

                        <div class="row col-md-12 justify-content-end text-right">
                            @if($tabla == "parametros")
                                <button type="button" class="btn btn-danger btn-sm mr-2" wire:click="destroyRol({{ $tabla_id }})">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                <form wire:submit.prevent="updateRol()">
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control" placeholder="nombre"
                                               wire:model.defer="tabla_nombre">
                                        <span class="input-group-append">
                                            <button type="submit" class="btn btn-success btn-flat">
                                                <i class="fas fa-save"></i>
                                            </button>
                                          </span>
                                    </div>
                                </form>
                                <button type="button" class="btn btn-primary btn-sm float-right ml-2 mr-2" wire:click="updateRolUsuarios">
                                    Actualizar Usuarios
                                </button>
                            @endif
                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal" wire:click="limpiar"
                                    id="boton_rol_modal_cerrar">{{ __('Close') }}</button>
                        </div>

                    </div>
                </div>

            </div>

            {!! verSpinner() !!}

        </div>
    </div>
</div>
