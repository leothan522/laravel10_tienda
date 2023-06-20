<div class="card card-outline card-navy" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="card-header">
        <h3 class="card-title">
            @if($keywordTiposAjuste)
                Resultados de la Busqueda { <b class="text-danger">{{ $keywordTiposAjuste }}</b> }
                <button class="btn btn-tool text-danger" wire:click="limpiarTiposAjuste"><i class="fas fa-times-circle"></i>
                </button>
            @else
                Tipos de Ajuste Registrados [ <b class="text-navy">{{ $rowsTiposAjuste }}</b> ]
            @endif
        </h3>

        <div class="card-tools">
            <ul class="pagination pagination-sm float-right m-1">
                {{ $listarTiposAjuste->links() }}
            </ul>
        </div>
    </div>
    <div class="card-body table-responsive p-0" style="height: 610px;">
        <table class="table table-head-fixed table-hover text-nowrap">
            <thead>
            <tr class="text-navy">
                <th style="width: 20%">Codigo</th>
                <th>Descripción</th>
                <th>Tipo</th>
                <th style="width: 5%;">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            @if($listarTiposAjuste->isNotEmpty())
                @foreach($listarTiposAjuste as $tipo)
                    <tr>
                        <td>{{ $tipo->codigo }}</td>
                        <td>{{ $tipo->descripcion }}</td>
                        <td>
                            @if($tipo->tipo == 1)
                                Entrada
                            @else
                                Salida
                            @endif
                        </td>
                        <td class="justify-content-end">
                            <div class="btn-group">
                                <button wire:click="editTiposAjuste({{ $tipo->id }})" class="btn btn-primary btn-sm"
                                @if(!comprobarPermisos()) disabled @endif >
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button wire:click="destroyTiposAjuste({{ $tipo->id }})" class="btn btn-primary btn-sm"
                                @if(!comprobarPermisos()) disabled @endif >
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
                @else
                <tr class="text-center">
                    <td colspan="3">
                        <span>Aún no se ha creado un Tipo de Ajuste.</span>
                    </td>
                </tr>
            @endif

            </tbody>
        </table>
    </div>
</div>
