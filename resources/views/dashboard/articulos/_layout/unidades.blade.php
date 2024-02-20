<div wire:ignore.self class="modal fade" id="modal-sm-articulos-unidades" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">


            <div class="modal-header bg-navy">
                <h4 class="modal-title">Unidad</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="text-white" aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="card-body p-0">

                <div class="table-responsive p-0" style="height: 40vh;">

                    <table class="table table-sm table-head-fixed table-hover text-nowrap">
                        <thead>
                        <tr class="text-navy">
                            <th style="width: 10%">Código</th>
                            <th>Nombre</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($primaria)
                            <tr>
                                <td>{{ $primaria_code }}</td>
                                <td>
                                    {{ $primaria_nombre }}
                                    <small class="badge float-right">
                                        Primaria
                                    </small>
                                </td>
                                <td class="text-right">
                                    @if($primaria_id == $unidades_id)
                                        <button class="btn btn-sm text-primary m-0" wire:click="limpiarUnidades">
                                            <i class="fas fa-undo"></i>
                                        </button>
                                    @else
                                    <button class="btn btn-sm text-primary" wire:click="edit" @if(!$primaria_edit) disabled @endif >
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    @endif
                                </td>
                            </tr>
                            @if($listarUnd->isNotEmpty())
                                @foreach($listarUnd as $unidad)
                                    <tr>
                                        <td>{{ $unidad->unidad->codigo }}</td>
                                        <td>
                                            {{ $unidad->unidad->nombre }}
                                        </td>
                                        <td class="text-right">
                                            <button
                                                class="btn btn-sm text-danger" wire:click="destroy({{ $unidad->id }})">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        @else
                            <tr>
                                <td colspan="3" class="text-center text-danger">
                                    Unidad Primaria NO definida.
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>


                </div>

                <form wire:submit="save" class="p-0">
                    <table class="table table-sm">
                        <tbody>
                        <tr>
                            <td style="width: 10%;">
                                <label>
                                    @if(!$primaria_id || $editar)
                                        Primaria
                                    @else
                                        Secundaria:
                                    @endif
                                </label>
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="input-group">
                                        <select class="custom-select custom-select-sm @error("unidades_id") is-invalid @enderror" wire:model="unidades_id" id="unidades_select_unidad">
                                            <option value="">Seleccione</option>
                                            @foreach($listarUnidades as $unidad)
                                                @if($unidad->ver)
                                                    <option value="{{ $unidad->id }}">{{ $unidad->codigo }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </td>
                            <td style="width: 5%;">
                                <button type="submit" class="btn @if($editar) btn-primary @else btn-success @endif btn-sm"
                                        @if(!comprobarPermisos('articulos.unidades')) disabled @endif >
                                    <i class="fas fa-save"></i>
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </form>



            </div>

            <div class="modal-footer card-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
            </div>

            {!! verSpinner() !!}

            <div class="overlay-wrapper d-none cargar_ArtUnd">
                <div class="overlay">
                    <div class="spinner-border text-navy" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
