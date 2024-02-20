<div wire:ignore.self class="modal fade" id="modal-sm-articulos-identificadores" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">


            <div class="modal-header bg-navy">
                <h4 class="modal-title">Identificadores</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="text-white" aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="card-body p-0">

                <div class="table-responsive p-0" style="height: 40vh;">

                    <table class="table table-sm table-head-fixed table-hover text-nowrap">
                        <thead>
                        <tr class="text-navy">
                            <th>Serial</th>
                            <th class="text-right" style="width: 10%">Cantidad</th>
                            <th style="width: 5%">&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($listarIdentificadores->isNotEmpty())
                            @foreach($listarIdentificadores as $identificador)
                                <tr>
                                    <td>{{ $identificador->serial }}</td>
                                    <td class="text-right">{{ formatoMillares($identificador->cantidad, 3) }}</td>
                                    <td class="text-right">
                                        @if($identificadores_id == $identificador->id)
                                            <button class="btn btn-sm text-primary m-0" wire:click="limpiarIdentificadores">
                                                <i class="fas fa-undo"></i>
                                            </button>
                                        @else
                                            <button class="btn btn-sm text-danger m-0" wire:click="edit({{ $identificador->id }})">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm text-danger m-0" wire:click="destroy({{ $identificador->id }})">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3" class="text-center text-danger">
                                    Sin registros guardados.
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
                            <td>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm @error("serial") is-invalid @enderror" wire:model="serial" placeholder="Serial">
                                    </div>
                                </div>
                            </td>
                            <td style="width: 30%;">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm @error("cantidad") is-invalid @enderror" wire:model="cantidad" placeholder="Cantidad">
                                    </div>
                                </div>
                            </td>
                            <td style="width: 5%;">
                                <button type="submit" class="btn @if($identificadores_id) btn-primary @else btn-success @endif btn-sm"
                                        @if(!comprobarPermisos('articulos.identificadores')) disabled @endif >
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

            <div class="overlay-wrapper d-none cargar_indentificador">
                <div class="overlay">
                    <div class="spinner-border text-navy" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
