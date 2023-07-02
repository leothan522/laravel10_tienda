<div class="card card-outline card-navy" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="card-header">
        <h3 class="card-title">
            @if(/*$keyword*/false)
                Resultados de la Búsqueda { <b class="text-danger">{{ $keyword }}</b> }
                <button class="btn btn-tool text-danger" wire:click="cerrarBusqueda"><i class="fas fa-times-circle"></i>
                </button>
            @else
                Ofertas Registradas [ <b class="text-navy">{{ $rowsOfertas }}</b> ]
            @endif
        </h3>

        <div class="card-tools pt-1">
            <ul class="pagination pagination-sm float-right">
                {{ $listarOfertas->links() }}
            </ul>
        </div>
    </div>
    <div class="card-body table-responsive p-0" {{--style="height: 400px;"--}}>
        <table class="table {{--table-head-fixed--}} table-hover text-nowrap">
            <thead>
            <tr class="text-navy">
                <th>ID</th>
                <th>Afectados</th>
                <th>Categoria</th>
                <th>Articulo</th>
                <th>Desde</th>
                <th>Hasta</th>
                <th class="text-right">Descuento %</th>
                <th style="width: 5%;">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            @if($listarOfertas->isNotEmpty())
                @foreach($listarOfertas as $oferta)
                    <tr>
                        <td>{{ $oferta->id }}</td>
                        <td>
                            @if($oferta->afectados == 0) TODOS @endif
                            @if($oferta->afectados == 1) CATEGORIA @endif
                            @if($oferta->afectados == 2) ARTICULO @endif
                        </td>
                        <td>
                            @if($oferta->categorias_id)
                                {{ $oferta->categoria->codigo }}
                            @else
                                --
                            @endif
                        </td>
                        <td>
                            @if($oferta->articulos_id)
                                {{ $oferta->articulo->codigo }}
                            @else
                                --
                            @endif
                        </td>
                        <td>
                            {{ verFecha($oferta->desde, 'd/m/Y h:i a') }}
                        </td>
                        <td>{{ verFecha($oferta->hasta, 'd/m/Y h:i a') }}</td>
                        <td class="text-right">{{ $oferta->descuento }}%</td>
                        <td class="justify-content-end">
                            <div class="btn-group">
                                <button wire:click="edit({{ $oferta->id }})" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button wire:click="destroy({{ $oferta->id }})" class="btn btn-primary btn-sm">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr class="text-center">
                    <td colspan="8">
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
    {!! verSpinner() !!}
</div>
