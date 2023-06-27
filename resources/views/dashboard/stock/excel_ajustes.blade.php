@php
    $border = 'border: 1px solid #000000;';
    $color = 'background-color: #0c84ff;';
@endphp

@if($reporte == "numero")

    @php($columnas = 0)

    <table>
        <tr>
            <td colspan="2">Tienda</td>
            <td colspan="{{ $columnas }}" style="text-align: end">Usuario:</td>
        </tr>
        <tr>
            <td colspan="2">{{ $empresa->nombre }}</td>
            <td colspan="{{ $columnas }}" style="text-align: end">{{ auth()->user()->email }}</td>
        </tr>
        <tr>
            <td colspan="2">R.I.F: {{ $empresa->rif }}</td>
            <td colspan="{{ $columnas }}" style="text-align: end">
                Fecha: {{ $hoy }}</td>
        </tr>
        <tr>
            <td colspan="{{ $columnas + 3 }}">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="{{ $columnas + 3 }}" style="text-align: center; font-weight: bold;">AJUSTES DE ENTRADA Y SALIDA
                POR NUMERO
            </td>
        </tr>
        @if($desde || $hasta)
            <tr>
                <td colspan="{{ $columnas + 3 }}" style="text-align: center;">
                    @if($desde)
                        Desde: {{ verFecha($desde) }} &nbsp;
                    @endif
                    @if($hasta)
                        Hasta: {{ verFecha($hasta) }} &nbsp;
                    @endif
                </td>
            </tr>
        @endif

        @if($anulado != "all" || $tipo != "all" || $articulo != "all" || $almacen != "all")
            <tr>
                <td colspan="{{ $columnas + 3 }}" style="text-align: center;">
                    @if($anulado != "all")
                        @if($anulado)
                            Anulado: NO; &nbsp;
                        @else
                            Anulado: SI; &nbsp;
                        @endif&nbsp;
                    @endif
                    @if($tipo != "all")
                        Ajuste: {{ $tipo->codigo }}; &nbsp;
                    @endif
                    @if($articulo != "all")
                        Articulo: {{ $articulo->codigo }}; &nbsp;
                    @endif
                    @if($almacen != "all")
                        Almacen: {{ $almacen->codigo }}; &nbsp;
                    @endif
                </td>
            </tr>
        @endif

        <tr>
            <td colspan="{{ $columnas + 3 }}">&nbsp;</td>
        </tr>
        <tr>
            <td style="{{ $color }}{{ $border }}">Codigo</td>
            <td style="{{ $color }}{{ $border }}">Descripción</td>
            <td style="{{ $color }}{{ $border }}">Fecha</td>
        </tr>
        @php($i = 0)
        @foreach($listarAjustes as $ajuste)

            @if($desde)
                @php($desde = \Carbon\Carbon::parse($desde))
                @php($comparar = \Carbon\Carbon::parse($ajuste->fecha))
                @if($comparar->lt($desde))
                    @continue
                @endif
            @endif

            @if($hasta)
                @php($hasta = \Carbon\Carbon::parse($hasta))
                @php($comparar = \Carbon\Carbon::parse($ajuste->fecha))
                @if($comparar->isAfter($hasta->addHours(12)))
                    @continue
                @endif
            @endif

            @if($anulado != "all" && $ajuste->estatus != $anulado)
                @continue
            @endif

            @if($tipo != "all" || $articulo != "all" || $almacen != "all")

                @php($resultadoTipos = array())
                @php($resultadoArticulos = array())
                @php($resultadoAlmacenes = array())

                @foreach($ajuste->detalles as $detalle)
                    @if($tipo != "all" && $detalle->tipos_id == $tipo->id)
                        @php($resultadoTipos[] = true)
                    @endif
                    @if($articulo != "all" && $detalle->articulos_id == $articulo->id)
                        @php($resultadoArticulos[] = true)
                    @endif
                    @if($almacen != "all" && $detalle->almacenes_id == $almacen->id)
                        @php($resultadoAlmacenes[] = true)
                    @endif
                @endforeach

                @if($tipo != "all" && empty($resultadoTipos))
                    @continue
                @endif

                @if($articulo != "all" && empty($resultadoArticulos))
                    @continue
                @endif

                @if($almacen != "all" && empty($resultadoAlmacenes))
                    @continue
                @endif

            @endif


            <tr>
                <td style="{{ $border }}">
                    @if(!$ajuste->estatus)
                        *
                    @endif
                    {{ $ajuste->codigo }}
                </td>
                <td style="{{ $border }}">
                    {{ $ajuste->descripcion }}
                    @if(!$ajuste->estatus)
                        (*Anulado)
                    @endif
                </td>
                <td style="{{ $border }}">{{ \Carbon\Carbon::parse($ajuste->fecha)->format('d-m-Y h:i a') }}</td>
            </tr>
        @endforeach


    </table>

@else

    @php($columnas = 3)

    <table>
        <tr>
            <td colspan="2">Tienda</td>
            <td colspan="{{ $columnas + 1 }}" style="text-align: end">Usuario:</td>
        </tr>
        <tr>
            <td colspan="2">{{ $empresa->nombre }}</td>
            <td colspan="{{ $columnas + 1 }}" style="text-align: end">{{ auth()->user()->email }}</td>
        </tr>
        <tr>
            <td colspan="2">R.I.F: {{ $empresa->rif }}</td>
            <td colspan="{{ $columnas + 1 }}" style="text-align: end">
                Fecha: {{ $hoy }}</td>
        </tr>
        <tr>
            <td colspan="{{ $columnas + 3 }}">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="{{ $columnas + 3 }}" style="text-align: center; font-weight: bold;">AJUSTES DE ENTRADA Y SALIDA
                POR ARTICULOS
            </td>
        </tr>
        @if($desde || $hasta)
            <tr>
                <td colspan="{{ $columnas + 3 }}" style="text-align: center;">
                    @if($desde)
                        Desde: {{ verFecha($desde) }} &nbsp;
                    @endif
                    @if($hasta)
                        Hasta: {{ verFecha($hasta) }} &nbsp;
                    @endif
                </td>
            </tr>
        @endif

        @if($anulado != "all" || $tipo != "all" || $articulo != "all" || $almacen != "all")
            <tr>
                <td colspan="{{ $columnas + 3 }}" style="text-align: center;">
                    @if($anulado != "all")
                        @if($anulado)
                            Anulado: NO; &nbsp;
                        @else
                            Anulado: SI; &nbsp;
                        @endif&nbsp;
                    @endif
                    @if($tipo != "all")
                        Ajuste: {{ $tipo->codigo }}; &nbsp;
                    @endif
                    @if($articulo != "all")
                        Articulo: {{ $articulo->codigo }}; &nbsp;
                    @endif
                    @if($almacen != "all")
                        Almacen: {{ $almacen->codigo }}; &nbsp;
                    @endif
                </td>
            </tr>
        @endif
        <tr>
            <td colspan="{{ $columnas + 3 }}">&nbsp;</td>
        </tr>
        @foreach($listarAjustes as $ajuste)
            @if(!$ajuste->contador)
                @continue
            @endif
            @if($articulo != "all" && $ajuste->id != $articulo->id)
                @continue
            @endif
            <tr>
                <td>{{ $ajuste->codigo }}</td>
                <td>{{ $ajuste->descripcion }}</td>
                <td colspan="{{ $columnas + 1 }}">&nbsp;</td>
            </tr>
            <tr>
                <td style="{{ $color }}{{ $border }}">Codigo</td>
                <td style="{{ $color }}{{ $border }}">Descripción</td>
                <td style="{{ $color }}{{ $border }}">Fecha</td>
                <td style="{{ $color }}{{ $border }}">Tipo</td>
                <td style="{{ $color }}{{ $border }}">Almacen</td>
                <td style="{{ $color }}{{ $border }}">Total</td>
            </tr>
            @foreach($ajuste->detalles as $detalle)

                @if($desde)
                    @php($desde = \Carbon\Carbon::parse($desde))
                    @php($comparar = \Carbon\Carbon::parse($detalle->ajustes->fecha))
                    @if($comparar->lt($desde))
                        @continue
                    @endif
                @endif

                @if($hasta)
                    @php($hasta = \Carbon\Carbon::parse($hasta))
                    @php($comparar = \Carbon\Carbon::parse($detalle->ajustes->fecha))
                    @if($comparar->isAfter($hasta->addHours(12)))
                        @continue
                    @endif
                @endif

                @if($anulado != "all" && $detalle->ajustes->estatus != $anulado)
                    @continue
                @endif

                @if($tipo != "all" || $articulo != "all" || $almacen != "all")

                    @php($resultadoTipos = array())
                    @php($resultadoArticulos = array())
                    @php($resultadoAlmacenes = array())

                    @if($tipo != "all" && $detalle->tipos_id == $tipo->id)
                        @php($resultadoTipos[] = true)
                    @endif
                    @if($articulo != "all" && $detalle->articulos_id == $articulo->id)
                        @php($resultadoArticulos[] = true)
                    @endif
                    @if($almacen != "all" && $detalle->almacenes_id == $almacen->id)
                        @php($resultadoAlmacenes[] = true)
                    @endif

                    @if($tipo != "all" && empty($resultadoTipos))
                        @continue
                    @endif

                    @if($articulo != "all" && empty($resultadoArticulos))
                        @continue
                    @endif

                    @if($almacen != "all" && empty($resultadoAlmacenes))
                        @continue
                    @endif

                @endif

                <tr>
                    <td style="{{ $border }}">
                        @if(!$detalle->ajustes->estatus)
                            *
                        @endif
                        {{ $detalle->ajustes->codigo }}
                    </td>
                    <td style="{{ $border }}">
                        {{ $detalle->ajustes->descripcion }}
                        @if(!$detalle->ajustes->estatus)
                            (*Anulado)
                        @endif
                    </td>
                    <td style="{{ $border }}">{{ verFecha($detalle->ajustes->fecha, 'd/m/Y h:i a') }}</td>
                    <td style="{{ $border }}">{{ $detalle->tipo->codigo }}</td>
                    <td style="{{ $border }}">{{ $detalle->almacen->codigo }}</td>
                    <td style="{{ $border }}">
                        @if($detalle->tipo->tipo == 2)
                            {{ $detalle->cantidad * (-1) }}
                        @else
                            {{ $detalle->cantidad }}
                        @endif
                    </td>
                </tr>
            @endforeach

            <tr>
                <td colspan="3">&nbsp;</td>
                <td>Totales</td>
                <td>&nbsp;</td>
                <td>{{ $ajuste->total }}</td>
            </tr>
        @endforeach


    </table>

@endif
