<div class="card card-outline card-navy" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="card-header">
        <h3 class="card-title">
            @if($keywordCategorias)
                Resultados de la Busqueda { <b class="text-danger">{{ $keywordCategorias }}</b> }
                <button class="btn btn-tool text-danger" wire:click="limpiarCategorias"><i class="fas fa-times-circle"></i>
                </button>
            @else
                Categorias Registradas [ <b class="text-navy">{{ $rowsCategorias }}</b> ]
            @endif
        </h3>

        <div class="card-tools">
            <ul class="pagination pagination-sm float-right m-1">
                {{ $listarCategorias->links() }}
            </ul>
        </div>
    </div>
    <div class="card-body table-responsive p-0" style="height: 610px;">
        <table class="table table-head-fixed table-hover text-nowrap">
            <thead>
            <tr class="text-navy">
                <th style="width: 10%">Codigo</th>
                <th>Nombre</th>
                <th class="text-center" style="width: 10%"><i class="fas fa-boxes"></i></th>
                <th style="width: 5%;">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            @if($listarCategorias->isNotEmpty())
                @foreach($listarCategorias as $categoria)
                    <tr>
                        <td>{{ $categoria->codigo }}</td>
                        <td>{{ $categoria->nombre }}</td>
                        <td class="text-center">{{ formatoMillares($categoria->cantidad, 0) }}</td>
                        <td class="justify-content-end">
                            <div class="btn-group">
                                <button wire:click="editCategoria({{ $categoria->id }})" class="btn btn-primary btn-sm"
                                @if(!comprobarPermisos('categorias.edit')) disabled @endif >
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button wire:click="destroyCategoria({{ $categoria->id }})" class="btn btn-primary btn-sm"
                                @if(!comprobarPermisos('categorias.destroy')) disabled @endif >
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
                @else
                <tr class="text-center">
                    <td colspan="4">
                        <span>Aún se se ha creado una Categoria.</span>
                    </td>
                </tr>
            @endif

            </tbody>
        </table>
    </div>
</div>
