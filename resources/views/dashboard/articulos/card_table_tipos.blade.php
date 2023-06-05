<div class="card card-outline card-navy" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="card-header">
        <h3 class="card-title">
            @if($keywordTipos)
                Resultados de la Busqueda { <b class="text-danger">{{ $keywordTipos }}</b> }
                <button class="btn btn-tool text-danger" wire:click="limpiarTipos"><i class="fas fa-times-circle"></i></button>
            @else
                Registrados [ <b class="text-navy">{{ $rowsTipos }}</b> ]
            @endif
        </h3>

        <div class="card-tools">
            <ul class="pagination pagination-sm float-right m-1">
                {{ $listarTipos->links() }}
            </ul>
        </div>
    </div>
    <div class="card-body table-responsive p-0" style="height: 610px;">
        <table class="table table-head-fixed table-hover text-nowrap">
            <thead>
            <tr class="text-navy">
                <th>Nombre</th>
                <th style="width: 5%;">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            @if($listarTipos->isNotEmpty())
                @foreach($listarTipos as $tipo)
                    <tr>
                        <td>{{ $tipo->nombre }}</td>
                        <td class="justify-content-end">
                            <div class="btn-group">
                                <button wire:click="editTipo({{ $tipo->id }})" class="btn btn-primary btn-sm"
                                @if(!comprobarPermisos('tipos.edit')) disabled @endif >
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button wire:click="destroyTipo({{ $tipo->id }})" class="btn btn-primary btn-sm"
                                @if(!comprobarPermisos('tipos.destroy')) disabled @endif >
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
                @else
                <tr class="text-center">
                    <td colspan="2">
                        <span>Aún se se ha creado.</span>
                    </td>
                </tr>
            @endif

            </tbody>
        </table>
    </div>
</div>
