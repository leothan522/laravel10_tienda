<div class="card card-outline card-navy" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="card-header">
        <h3 class="card-title">
            @if($keyword)
                Resultados de la Búsqueda { <b class="text-danger">{{ $keyword }}</b> }
                <button class="btn btn-tool text-danger" wire:click="limpiarArticulos"><i class="fas fa-times-circle"></i>
                </button>
            @else
                Artículos Registrados [ <b class="text-navy">{{ $rowsArticulos }}</b> ]
            @endif
        </h3>

        <div class="card-tools pt-1">
            <ul class="pagination pagination-sm float-right">
                {{ $listarArticulos->links() }}
            </ul>
        </div>
    </div>
    <div class="card-body table-responsive p-0" {{--style="height: 400px;"--}}>
        <table class="table {{--table-head-fixed--}} table-hover text-nowrap">
            <thead>
            <tr class="text-navy">
                <th style="width: 10%">Código</th>
                <th>Descripción</th>
                <th style="width: 5%;">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            @if($listarArticulos->isNotEmpty())
                @foreach($listarArticulos as $articulo)
                    <tr class="@if($articulo_id == $articulo->id) text-bold table-warning @endif">
                        <td>{{ $articulo->codigo }}</td>
                        <td>{{ $articulo->descripcion }}</td>
                        <td class="justify-content-end">
                            <div class="btn-group">
                                <button wire:click="showArticulos({{ $articulo->id }})" class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr class="text-center">
                    <td colspan="3">
                        @if($keyword)
                            <span>Sin resultados</span>
                        @else
                            <span>Sin registros guardados</span>
                        @endif
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
</div>
