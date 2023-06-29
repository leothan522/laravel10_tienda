@php
    $border = 'border: 1px solid #000000;';
    $color = 'background-color: #0c84ff;';
@endphp

@php
    $columnas = 1;
    if ($reporte == "precios"){ $columnas = $columnas + 4; }
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
            Fecha: {{ $hoy }}</td>
    </tr>
    <tr>
        <td colspan="{{ $columnas + 3 }}">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="{{ $columnas + 3 }}" style="text-align: center; font-weight: bold;">
            ARTÍCULOS CON SUS
            @if($reporte == "unidades")
                UNIDADES
            @endif
            @if($reporte == "precios")
                PRECIOS
            @endif
            @if($reporte == "identificadores")
                IDENTIFICADORES
            @endif
        </td>
    </tr>
    @if($categoria != "all" || $unidad != "all" || $procedencia != "all" || $tributario != "all" || $tipo != "all" || $estatus != "all")
        <tr>
            <td colspan="{{ $columnas + 3 }}" style="text-align: center">
                @if($categoria != "all")
                    Categoria: {{ $categoria->nombre }}; &nbsp;
                @endif
                @if($unidad != "all")
                    Unidad: {{ $unidad->codigo }}; &nbsp;
                @endif
                @if($procedencia != "all")
                    Procedencia: {{ $procedencia->nombre }}; &nbsp;
                @endif
                @if($tributario != "all")
                    Tributario: {{ $tributario->codigo }}; &nbsp;
                @endif
                @if($tipo != "all")
                    Tipo: {{ $tipo->nombre }}; &nbsp;
                @endif
                @if($estatus != "all")
                    Estatus:
                    @if($estatus)
                        Activo
                    @else
                        Inactivo
                    @endif
                    &nbsp;
                @endif
            </td>
        </tr>
    @endif
    {{--@if($unidad || $almacen)
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
    @endif--}}
    <tr>
        <td colspan="{{ $columnas + 3 }}">&nbsp;</td>
    </tr>
    <tr>
        <td style="{{ $color }}{{ $border }}">Codigo</td>
        <td style="{{ $color }}{{ $border }}">Articulo</td>
        <td style="{{ $color }}{{ $border }}">Unidad</td>
        @if($reporte == "precios")
            <td style="{{ $color }}{{ $border }}">Moneda</td>
            <td style="{{ $color }}{{ $border }}">Precio</td>
            <td style="{{ $color }}{{ $border }}">I.V.A.</td>
            <td style="{{ $color }}{{ $border }}">Neto</td>
            <td style="{{ $color }}{{ $border }}">Al Cambio</td>
        @endif
    </tr>
    @php($i = 0)
    @foreach($listarArticulos as $articulo)

        @if($categoria != "all" && $categoria->id != $articulo->categorias_id)
            @continue
        @endif

        @if($unidad != "all")
            @php($noUnd = array())
            @if($articulo->get_unidades->isNotEmpty())
                @foreach($articulo->get_unidades as $get)
                    @if($get->unidades_id == $unidad->id)
                        @php($noUnd[] = true)
                    @endif
                @endforeach
            @endif
            @if($unidad->id != $articulo->unidades_id && empty($noUnd))
                @continue
            @endif
        @endif

        @if($procedencia != "all" && $procedencia->id != $articulo->procedencias_id)
            @continue
        @endif

        @if($tributario != "all" && $tributario->id != $articulo->tributarios_id)
            @continue
        @endif

        @if($tipo != "all" && $tipo->id != $articulo->tipos_id)
            @continue
        @endif

        @if($estatus != "all" && $estatus != $articulo->estatus)
            @continue
        @endif

        @if($unidad == "all" || $unidad->id == $articulo->unidades_id)
            <tr>
                <td style="{{ $border }}">
                    @if(!$articulo->estatus)
                        *
                    @endif
                    {{ $articulo->codigo }}
                </td>
                <td style="{{ $border }}">
                    {{ $articulo->descripcion }}
                    @if(!$articulo->estatus)
                        (* Inactivo)
                    @endif
                </td>
                <td style="{{ $border }}">
                    {{ $articulo->unidad->codigo }}
                </td>
                @if($reporte == "precios")
                    <td style="{{ $border }}">
                        @if(!empty($articulo->precios))
                            {{ $articulo->precios['moneda'] }}
                        @endif
                    </td>
                    <td style="{{ $border }}">
                        @if(!empty($articulo->precios))
                            @if($articulo->precios['moneda'] == "Bolivares")
                                {{ $articulo->precios['precio_bolivares'] }}
                            @else
                                {{ $articulo->precios['precio_dolares'] }}
                            @endif
                        @endif
                    </td>
                    <td style="{{ $border }}">
                        @if(!empty($articulo->precios))
                            @if($articulo->precios['moneda'] == "Bolivares")
                                {{ $articulo->precios['iva_bolivares'] }}
                            @else
                                {{ $articulo->precios['iva_dolares'] }}
                            @endif
                        @endif
                    </td>
                    <td style="{{ $border }}">
                        @if(!empty($articulo->precios))
                            @if($articulo->precios['moneda'] == "Bolivares")
                                {{ $articulo->precios['neto_bolivares'] }}
                            @else
                                {{ $articulo->precios['neto_dolares'] }}
                            @endif
                        @endif
                    </td>
                    <td style="{{ $border }}">
                        @if(!empty($articulo->precios))
                            @if($articulo->precios['moneda'] == "Bolivares")
                                {{ round($articulo->precios['neto_dolares'], 2) }}
                            @else
                                {{ round($articulo->precios['neto_bolivares'], 2) }}
                            @endif
                        @endif
                    </td>
                @endif
            </tr>
        @endif

        @if($articulo->get_unidades->isNotEmpty())
            @foreach($articulo->get_unidades as $get)
                @if($unidad == "all" || $unidad->id == $get->unidades_id)
                    <tr>
                        <td style="{{ $border }}">
                            {{ $articulo->codigo }}
                        </td>
                        <td style="{{ $border }}">
                            {{ $articulo->descripcion }}
                        </td>
                        <td style="{{ $border }}">
                            {{ $get->unidad->codigo }}
                        </td>
                        @if($reporte == "precios")
                            <td style="{{ $border }}">
                                @if(!empty($get->precios))
                                    {{ $get->precios['moneda'] }}
                                @endif
                            </td>
                            <td style="{{ $border }}">
                                @if(!empty($get->precios))
                                    @if($get->precios['moneda'] == "Bolivares")
                                        {{ $get->precios['precio_bolivares'] }}
                                    @else
                                        {{ $get->precios['precio_dolares'] }}
                                    @endif
                                @endif
                            </td>
                            <td style="{{ $border }}">
                                @if(!empty($get->precios))
                                    @if($get->precios['moneda'] == "Bolivares")
                                        {{ $get->precios['iva_bolivares'] }}
                                    @else
                                        {{ $get->precios['iva_dolares'] }}
                                    @endif
                                @endif
                            </td>
                            <td style="{{ $border }}">
                                @if(!empty($get->precios))
                                    @if($get->precios['moneda'] == "Bolivares")
                                        {{ $get->precios['neto_bolivares'] }}
                                    @else
                                        {{ $get->precios['neto_dolares'] }}
                                    @endif
                                @endif
                            </td>
                            <td style="{{ $border }}">
                                @if(!empty($get->precios))
                                    @if($get->precios['moneda'] == "Bolivares")
                                        {{ round($get->precios['neto_dolares'], 2) }}
                                    @else
                                        {{ round($get->precios['neto_bolivares'], 2) }}
                                    @endif
                                @endif
                            </td>
                        @endif
                    </tr>
                @endif
            @endforeach
        @endif
    @endforeach

</table>

