<div xmlns:wire="http://www.w3.org/1999/xhtml">

    <div class="col-12 table-responsive" >

        <table class="table table-striped">
            <thead>
            <tr>
                <th style="width: 2%;">Codigo</th>
                <th>Articulo</th>
                <th class="text-right" style="width: 10%;">Precio</th>
                <th class="text-right" style="width: 10%;">I.V.A.</th>
                <th class="text-right" style="width: 10%">Neto</th>
                <th class="text-right" style="width: 10%">Al Cambio</th>
                <th class="text-right" style="width: 10%;">Stock Actual</th>
                <th class="text-right" style="width: 10%;">Comprom.</th>
                <th class="text-right" style="width: 10%;">Disponible</th>
                <th style="width: 5%;">Und.</th>
                <th class="text-center" style="width: 2%;">Estatus</th>
                <th style="width: 5%;"></th>
            </tr>
            </thead>
            <tbody>
            @php($i = 0)
            @if($listarStock->isNotEmpty())
            @foreach($listarStock as $stock)

                @if(!empty($keywordStock))
                    @php($busqueda = array())
                    @foreach($keywordStock as $articulo)
                        @if($stock->articulos_id == $articulo['id'])
                            @php($busqueda[] = true)
                        @endif
                    @endforeach
                    @if(empty($busqueda))
                        @continue
                    @endif
                @endif

                @if(!$stock->actual)
                    @continue
                @endif
                @php($i++)
                <tr>
                    <td class="text-sm">{{ $stock->codigo }}</td>
                    <td>
                        @if(!$stock->activo)
                            <span class="btn-sm text-danger"><i class="fas fa-ban"></i></span>
                        @else
                            @if($stock->porcentaje > 0)
                                <i class="fas fa-gifts text-primary"></i>
                            @endif
                        @endif
                        <span class="text-sm">{{ $stock->articulo }}</span>
                    </td>
                    <td class="text-right">
                        @if($stock->moneda == "Dolares")
                            @if(!$stock->dolares)
                                <span class="btn-sm text-danger"><i class="fas fa-times"></i></span>
                            @endif
                            <span class="text-bold">$</span>
                            {{ formatoMillares($stock->dolares, 2) }}
                        @else
                            @if(!$stock->bolivares)
                                <span class="btn-sm text-danger"><i class="fas fa-times"></i></span>
                            @endif
                            {{ formatoMillares($stock->bolivares, 2) }}
                            <span class="text-bold">Bs.</span>
                        @endif
                    </td>
                    <td class="text-right">
                        @if($stock->moneda == "Dolares")
                            <span class="text-bold">$</span>
                            {{ formatoMillares($stock->iva_dolares, 2) }}
                        @else
                            {{ formatoMillares($stock->iva_bolivares, 2) }}
                            <span class="text-bold">Bs.</span>
                        @endif
                    </td>
                    <td class="text-right">
                        @if($stock->moneda == "Dolares")
                            <span class="text-bold">$</span>
                            {{ formatoMillares($stock->neto_dolares, 2) }}
                        @else
                            {{ formatoMillares($stock->neto_bolivares, 2) }}
                            <span class="text-bold">Bs.</span>
                        @endif
                    </td>
                    <td class="text-right">
                        @if($stock->moneda != "Dolares")
                            <span class="text-bold">$</span>
                            {{ formatoMillares($stock->neto_dolares, 2) }}
                        @else
                            {{ formatoMillares($stock->neto_bolivares, 2) }}
                            <span class="text-bold">Bs.</span>
                        @endif
                    </td>
                    <td class="text-right">{{ formatoMillares($stock->actual, 3) }}</td>
                    <td class="text-right">{{ formatoMillares($stock->comprometido, 3) }}</td>
                    <td class="text-right">{{ formatoMillares($stock->disponible, 3) }}</td>
                    <td>{{ $stock->unidad }}</td>
                    <td class="text-center">
                        @if($stock->estatus && ($stock->dolares || $stock->bolivares) && $stock->activo)
                            <button type="button" class="btn btn-sm"
                                    wire:click="setEstatus('{{ json_encode($stock->existencias) }}')"
                                    @if(!comprobarPermisos('stock.estatus')) disabled @endif >
                                <i class="fas fa-globe text-success"></i>
                            </button>
                        @else
                            <button type="button" class="btn btn-sm"
                                    @if(($stock->dolares || $stock->bolivares) && $stock->activo && comprobarPermisos('stock.estatus')) wire:click="setEstatus('{{ json_encode($stock->existencias) }}')"
                                    @else disabled @endif>
                                <i class="fas fa-eraser text-muted"></i>
                            </button>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="btn-group">

                            <button type="button" class="btn btn-info btn-sm"
                                    wire:click="showModal('{{ $stock->articulos_id }}', '{{ $stock->unidades_id }}', '{{ $stock->vendido }}', '{{ $stock->estatus }}', '{{ json_encode($stock->existencias) }}', '{{ $stock->dolares }}', '{{ $stock->bolivares }}', '{{ $stock->activo }}', '{{ $stock->porcentaje }}', '{{ $stock->oferta_dolares }}', '{{ $stock->oferta_bolivares }}')"
                                    data-toggle="modal" data-target="#modal-lg-stock" id="ver_modal_{{ $i }}">
                                <i class="fas fa-eye"></i>
                            </button>

                        </div>
                    </td>
                </tr>
            @endforeach
            @else
                <tr>
                    <td colspan="12" class="text-center">Sin Existencias</td>
                </tr>
            @endif
            </tbody>
        </table>

        <div class="row mr-2 justify-content-end">
            {{ $listarStock->links() }}
        </div>


    </div>

    {{--<div class="overlay-wrapper" wire:loading wire:target="setEstatus, showStock">
        <div class="overlay">
            <div class="spinner-border text-navy" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>--}}

</div>
