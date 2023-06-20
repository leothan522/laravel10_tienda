<div class="card card-outline card-navy" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="card-header">
        <h3 class="card-title">
            @if($keywordAlmacenes)
                Resultados de la Busqueda { <b class="text-danger">{{ $keywordAlmacenes }}</b> }
                <button class="btn btn-tool text-danger" wire:click="limpiarAlmacenes"><i class="fas fa-times-circle"></i>
                </button>
            @else
                Almacenes Registrados [ <b class="text-navy">{{ $rowsAlmacenes }}</b> ]
            @endif
        </h3>

        <div class="card-tools">
            <ul class="pagination pagination-sm float-right m-1">
                {{ $listarAlmacenes->links() }}
            </ul>
        </div>
    </div>
    <div class="card-body table-responsive p-0" style="height: 610px;">
        <table class="table table-head-fixed table-hover text-nowrap">
            <thead>
            <tr class="text-navy">
                <th style="width: 20%">Código</th>
                <th>Nombre</th>
                <th style="width: 5%;">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            @if($listarAlmacenes->isNotEmpty())
                @foreach($listarAlmacenes as $almacen)
                    <tr>
                        <td>{{ $almacen->codigo }}</td>
                        <td>{{ $almacen->nombre }}</td>
                        <td class="justify-content-end">
                            <div class="btn-group">
                                <button wire:click="editAlmacen({{ $almacen->id }})" class="btn btn-primary btn-sm"
                                @if(!comprobarPermisos()) disabled @endif >
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button wire:click="destroyAlmacen({{ $almacen->id }})" class="btn btn-primary btn-sm"
                                @if(!comprobarPermisos() || $almacen->tipo == 1) disabled @endif >
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
                @else
                <tr class="text-center">
                    <td colspan="3">
                        <span>Aún no se ha creado un Almacen.</span>
                    </td>
                </tr>
            @endif

            </tbody>
        </table>
    </div>
</div>
