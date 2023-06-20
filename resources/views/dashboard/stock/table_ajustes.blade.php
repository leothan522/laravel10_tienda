<div class="card card-outline card-navy" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="card-header">
        <h3 class="card-title">
            @if(/*$keyword*/false)
                Resultados de la Busqueda { <b class="text-danger">{{ $keyword }}</b> }
                <button class="btn btn-tool text-danger" wire:click="limpiar"><i class="fas fa-times-circle"></i>
                </button>
            @else
                Ajustes de [Entrada|Salida]
            @endif
        </h3>

        <div class="card-tools pt-1">
            <ul class="pagination pagination-sm float-right">
                {{ $listarAjustes->links() }}
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
            @if($listarAjustes->isNotEmpty())
                @foreach($listarAjustes as $ajuste)
                    <tr class="@if($ajuste_id == $ajuste->id) text-bold table-warning @endif">
                        <td @if(!$ajuste->estatus) class="text-muted text-sm" @endif>{{ $ajuste->codigo }}</td>
                        <td @if(!$ajuste->estatus) class="text-muted text-sm" @endif>
                            @if(!$ajuste->estatus)
                                <span class="btn-xs"><i class="fas fa-ban"></i></span>
                            @endif
                            {{ $ajuste->descripcion }}
                        </td>
                        <td class="justify-content-end">
                            <div class="btn-group">
                                <button wire:click="showAjustes({{ $ajuste->id }})" class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr class="text-center">
                    <td colspan="3">
                        @if(/*$keyword*/false)
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
    <div class="overlay-wrapper" wire:loading wire:target="empresa_id, show, verAjustes, saveAjustes, destroyAjustes, confirmedBorrarAjuste">
        <div class="overlay">
            <div class="spinner-border text-navy" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
    <div class="overlay-wrapper d-none cargar_buscar">
        <div class="overlay">
            <div class="spinner-border text-navy" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
</div>
