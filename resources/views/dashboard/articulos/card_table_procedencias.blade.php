<div class="card card-outline card-navy" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="card-header">
        <h3 class="card-title">
            @if($keywordProcedencias)
                Resultados de la Busqueda { <b class="text-danger">{{ $keywordProcedencias }}</b> }
                <button class="btn btn-tool text-danger" wire:click="limpiarProcedencias"><i class="fas fa-times-circle"></i>
                </button>
            @else
                Procedencias Registradas [ <b class="text-navy">{{ $rowsProcedencias }}</b> ]
            @endif
        </h3>

        <div class="card-tools">
            <ul class="pagination pagination-sm float-right m-1">
                {{ $listarProcedencias->links() }}
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
            @if($listarProcedencias->isNotEmpty())
                @foreach($listarProcedencias as $procedencia)
                    <tr>
                        <td>{{ $procedencia->codigo }}</td>
                        <td>{{ $procedencia->nombre }}</td>
                        <td class="justify-content-end">
                            <div class="btn-group">
                                <button wire:click="editProcedencia({{ $procedencia->id }})" class="btn btn-primary btn-sm"
                                @if(!comprobarPermisos('procedencias.edit')) disabled @endif >
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button wire:click="destroyProcedencia({{ $procedencia->id }})" class="btn btn-primary btn-sm"
                                @if(!comprobarPermisos('procedencias.destroy')) disabled @endif >
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
                @else
                <tr class="text-center">
                    <td colspan="3">
                        <span>Aún se se ha creado una Procedencia.</span>
                    </td>
                </tr>
            @endif

            </tbody>
        </table>
    </div>
</div>
