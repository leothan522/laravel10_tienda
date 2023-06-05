<div class="col-12 table-responsive" xmlns:wire="http://www.w3.org/1999/xhtml">

    <table class="table table-striped">
        <thead>
        <tr>
            <th style="width: 2%;">#</th>
            <th>Articulo</th>
            <th class="text-right" style="width: 10%;">Precio</th>
            <th class="text-right" style="width: 10%;">I.V.A.</th>
            <th class="text-right" style="width: 10%">Neto</th>
            <th class="text-right" style="width: 10%">Al Cambio</th>
            <th class="text-right" style="width: 10%;">Stock Actual</th>
            <th class="text-right" style="width: 10%;">Comprom.</th>
            <th class="text-right" style="width: 10%;">Disponible</th>
            <th class="text-center" style="width: 10%;">Estatus</th>
            <th style="width: 5%;"></th>
        </tr>
        </thead>
        <tbody>
        @php($i = 0)
        @foreach($listarStock as $stock)
            @php($i++)
            <tr>
                <td class="text-muted text-sm">{{ $i }}</td>
                <td>
                    @if(!$stock->activo)
                        <span class="btn-sm text-danger"><i class="fas fa-ban"></i></span>
                    @endif
                    {{ $stock->articulo->descripcion }}
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
                <td class="text-center">
                    @if($stock->estatus && ($stock->dolares || $stock->bolivares) && $stock->activo)
                        <button type="button" class="btn btn-sm" wire:click="setEstatus({{ $stock->id }})">
                            <i class="fas fa-globe text-success"></i>
                        </button>
                    @else
                        <button type="button" class="btn btn-sm" @if(($stock->dolares || $stock->bolivares) && $stock->activo) wire:click="setEstatus({{ $stock->id }})" @else disabled @endif>
                            <i class="fas fa-eraser text-muted"></i>
                        </button>
                    @endif
                    <span class="text-sm ml-1">ID: {{--{{ $stock->id }}--}}1</span>
                </td>
                <td class="text-center">
                    <div class="btn-group">

                        <button type="button" class="btn btn-info btn-sm" wire:click="showModal({{ $stock->id }})"
                        data-toggle="modal" data-target="#modal-lg-stock">
                            <i class="fas fa-eye"></i>
                        </button>

                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>


</div>

