<div class="card card-outline card-navy" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="card-header">
        <h3 class="card-title">
            @if($keywordUnidades)
                Resultados de la Busqueda { <b class="text-danger">{{ $keywordUnidades }}</b> }
                <button class="btn btn-tool text-danger" wire:click="limpiarUnidades"><i class="fas fa-times-circle"></i>
                </button>
            @else
                Unidades Registradas [ <b class="text-navy">{{ $rowsUnidades }}</b> ]
            @endif
        </h3>

        <div class="card-tools">
            <ul class="pagination pagination-sm float-right m-1">
                {{ $listarUnidades->links() }}
            </ul>
        </div>
    </div>
    <div class="card-body table-responsive p-0" style="height: 610px;">
        <table class="table table-head-fixed table-hover text-nowrap">
            <thead>
            <tr class="text-navy">
                <th style="width: 20%">Codigo</th>
                <th>Nombre</th>
                <th style="width: 5%;">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            @if($listarUnidades->isNotEmpty())
                @foreach($listarUnidades as $unidad)
                    <tr>
                        <td>{{ $unidad->codigo }}</td>
                        <td>{{ $unidad->nombre }}</td>
                        <td class="justify-content-end">
                            <div class="btn-group">
                                <button wire:click="editUnidad({{ $unidad->id }})" class="btn btn-primary btn-sm"
                                @if(!comprobarPermisos('unidades.edit')) disabled @endif >
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button wire:click="destroyUnidad({{ $unidad->id }})" class="btn btn-primary btn-sm"
                                @if(!comprobarPermisos('unidades.destroy')) disabled @endif >
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
                @else
                <tr class="text-center">
                    <td colspan="3">
                        <span>Aún se se ha creado una Unidad.</span>
                    </td>
                </tr>
            @endif

            </tbody>
        </table>
    </div>
</div>
