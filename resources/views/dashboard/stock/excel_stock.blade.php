@php
    $border = 'border: 1px solid #000000;';
    $color = 'background-color: #0c84ff;';
@endphp

@php
    $columnas = 0;
    if ($tipo == "all" || $tipo == "actual"){ $columnas++; }
    if ($tipo == "all" || $tipo == "comprometido"){ $columnas++; }
    if ($tipo == "all" || $tipo == "disponible"){ $columnas++; }
    if ($tipo == "all" || $tipo == "vendido"){ $columnas++; }

@endphp

<table>
    <tr>
        <td colspan="3">Tienda</td>
        <td colspan="{{ $columnas }}" style="text-align: end">Usuario:</td>
    </tr>
    <tr>
        <td colspan="3">{{ $empresa->nombre }}</td>
        <td colspan="{{ $columnas }}" style="text-align: end">{{ auth()->user()->email }}</td>
    </tr>
    <tr>
        <td colspan="3">R.I.F: {{ $empresa->rif }}</td>
        <td colspan="{{ $columnas }}" style="text-align: end">
            Fecha: {{ $fecha }}</td>
    </tr>
    <tr>
        <td colspan="{{ $columnas + 3 }}">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="{{ $columnas + 3 }}" style="text-align: center; font-weight: bold;">ARTÍCULOS CON SU STOCK</td>
    </tr>
    @if($nivel != "all" || $tipo != "all")
        <tr>
            <td colspan="{{ $columnas + 3 }}" style="text-align: center">
                @if($nivel != "all")
                    Nivel de Stock: {{ ucwords($nivel) }} a 0;
                @endif
                @if($tipo != "all")
                    Tipo de Stock: {{ ucwords($tipo) }};
                @endif
                &nbsp;
            </td>
        </tr>
    @endif
    @if($unidad || $almacen)
        <tr>
            <td colspan="{{ $columnas + 3 }}" style="text-align: center">
                @if($unidad)
                    Unidad: {{ $unidad }};
                @endif
                @if($almacen)
                    Almacen: {{ $almacen }};
                @endif
                &nbsp;
            </td>
        </tr>
    @endif
    <tr>
        <td colspan="{{ $columnas + 3 }}">&nbsp;</td>
    </tr>
    <tr>
        <td style="{{ $color }}{{ $border }}">Codigo</td>
        <td style="{{ $color }}{{ $border }}">Articulo</td>
        <td style="{{ $color }}{{ $border }}">Unidad</td>
        @if($tipo == "all" || $tipo == "actual")
            <td style="{{ $color }}{{ $border }}">Actual</td>
        @endif
        @if($tipo == "all" || $tipo == "comprometido")
            <td style="{{ $color }}{{ $border }}">Comprometido</td>
        @endif
        @if($tipo == "all" || $tipo == "disponible")
            <td style="{{ $color }}{{ $border }}">Disponible</td>
        @endif
        @if($tipo == "all" || $tipo == "vendido")
            <td style="{{ $color }}{{ $border }}">Vendido</td>
        @endif
    </tr>
    @php($i = 0)
    @foreach($listarStock as $stock)
        @if($nivel != "all")
            @if($tipo == "all" || $tipo == "actual")
                @if($nivel == "diferente" && $stock->actual == 0)
                    @continue
                @endif
                @if($nivel == "igual" && $stock->actual != 0)
                    @continue
                @endif
                @if($nivel == "mayor" && $stock->actual <= 0)
                    @continue
                @endif
                @if($nivel == "menor" && $stock->actual >= 0)
                    @continue
                @endif
            @else
                @if($tipo == "disponible")
                    @if($nivel == "diferente" && $stock->disponible == 0)
                        @continue
                    @endif
                    @if($nivel == "igual" && $stock->disponible != 0)
                        @continue
                    @endif
                    @if($nivel == "mayor" && $stock->disponible <= 0)
                        @continue
                    @endif
                    @if($nivel == "menor" && $stock->disponible >= 0)
                        @continue
                    @endif
                @endif
                @if($tipo == "comprometido")
                    @if($nivel == "diferente" && $stock->comprometido == 0)
                        @continue
                    @endif
                    @if($nivel == "igual" && $stock->comprometido != 0)
                        @continue
                    @endif
                    @if($nivel == "mayor" && $stock->comprometido <= 0)
                        @continue
                    @endif
                    @if($nivel == "menor" && $stock->comprometido >= 0)
                        @continue
                    @endif
                @endif
                @if($tipo == "vendido")
                    @if($nivel == "diferente" && $stock->vendido == 0)
                        @continue
                    @endif
                    @if($nivel == "igual" && $stock->vendido != 0)
                        @continue
                    @endif
                    @if($nivel == "mayor" && $stock->vendido <= 0)
                        @continue
                    @endif
                    @if($nivel == "menor" && $stock->vendido >= 0)
                        @continue
                    @endif
                @endif
            @endif
        @endif
        <tr>
            <td style="{{ $border }}">
                @if(!$stock->activo)
                    *
                @endif
                {{ $stock->codigo }}
            </td>
            <td style="{{ $border }}">
                {{ $stock->articulo }}
                @if(!$stock->activo)
                    (* Inactivo)
                @endif
            </td>
            <td style="{{ $border }}">{{ $stock->unidad }}</td>
            @if($tipo == "all" || $tipo == "actual")
                <td style="{{ $border }}">{{ $stock->actual }}</td>
            @endif
            @if($tipo == "all" || $tipo == "comprometido")
                <td style="{{ $border }}">{{ $stock->comprometido }}</td>
            @endif
            @if($tipo == "all" || $tipo == "disponible")
                <td style="{{ $border }}">{{ $stock->disponible }}</td>
            @endif
            @if($tipo == "all" || $tipo == "vendido")
                <td style="{{ $border }}">{{ $stock->vendido }}</td>
            @endif
        </tr>
    @endforeach
</table>

