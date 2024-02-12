<div wire:ignore.self class="modal fade" id="modal-roles-usuarios" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="modal-dialog modal-lg">
        <div class="modal-content fondo">
            <div class="modal-header">
                <div class="row col-12">

                    <div class="col-6">
                        <h4 class="modal-title">
                            Rol de Usuario
                        </h4>
                    </div>
                    <div class="col-md-5 justify-content-end">
                        <form wire:submit.prevent="save">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="nombre" wire:model.defer="nombre"
                                       required>
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>


            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active">Rol</li>
                            <li class="breadcrumb-item active">{{ ucfirst($nombre) }}</li>
                        </ol>
                    </div>
                </div>

                @include('dashboard.usuarios.show_permisos')

            </div>
            <div class="modal-footer row col-12 justify-content-between">
                <button type="button" class="btn btn-danger btn-sm" wire:click="destroy({{ $roles_id }})">
                    <i class="fas fa-trash-alt"></i>
                </button>
                <button type="button" class="btn btn-default btn-sm" wire:click="deletePermisos">
                    <i class="fas fa-trash-alt"></i> Quitar Todos
                </button>
                <button type="button" class="btn btn-primary btn-sm" wire:click="savePermisos" @if(!$cambios) disabled @endif>
                    <i class="fa fa-save"></i> Actualizar Permisos
                </button>
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal" wire:click="limpiarRoles" id="button_rol_modal_cerrar">
                    {{ __('Close') }}
                </button>
            </div>

            <div class="overlay-wrapper" wire:loading wire:target="save, destroy, savePermisos">
                <div class="overlay">
                    <div class="spinner-border text-navy" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>

            <div class="overlay-wrapper d-none" id="div_ver_spinner_roles">
                <div class="overlay">
                    <div class="spinner-border text-navy" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
