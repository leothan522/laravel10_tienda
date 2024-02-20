<div class="card card-navy" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="card-header">
        <h3 class="card-title">
            @if($keyword)
                Resultados de la Busqueda { <b class="text-warning">{{ $keyword }}</b> }
                <button class="btn btn-tool text-warning" wire:click="limpiarTributarios"><i class="fas fa-times-circle"></i>
                </button>
            @else
                Impuestos Registrados [ <b class="text-warning">{{ $rowsTributarios }}</b> ]
            @endif
        </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" wire:click="setLimit" @if($rows > $rowsTributarios) disabled @endif >
                <i class="fas fa-sort-amount-down-alt"></i> Ver más
            </button>
        </div>
    </div>
    <div class="card-body table-responsive p-0" style="height: 60vh;">
        <table class="table table-sm table-head-fixed table-hover text-nowrap">
            <thead>
            <tr class="text-navy">
                <th style="width: 20%">Codigo</th>
                <th class="text-center">Taza (%)</th>
                <th style="width: 5%;">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            @if($listarTributarios->isNotEmpty())
                @foreach($listarTributarios as $tributario)
                    <tr>
                        <td>{{ $tributario->codigo }}</td>
                        <td class="text-center">{{ formatoMillares($tributario->taza) }} <i class="fas fa-percentage"></i></td>
                        <td class="justify-content-end">
                            <div class="btn-group">
                                <button wire:click="edit({{ $tributario->id }})" class="btn btn-primary btn-sm"
                                @if(!comprobarPermisos('tributarios.edit')) disabled @endif >
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button wire:click="destroy({{ $tributario->id }})" class="btn btn-primary btn-sm"
                                @if(!comprobarPermisos('tributarios.destroy')) disabled @endif >
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
                @else
                <tr class="text-center">
                    <td colspan="3">
                        @if($keyword)
                            <span>Sin resultados.</span>
                        @else
                            <span>Aún se se ha creado un Impuesto.</span>
                        @endif
                    </td>
                </tr>
            @endif

            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <small>Mostrando {{ $listarTributarios->count() }}</small>
    </div>
</div>
