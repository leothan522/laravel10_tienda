@extends('layouts.adminlte_print')

@section('title', 'Tienda: '. $empresa)

@section('content')


    <div class="card card-navy" style="height: inherit; width: inherit; transition: all 0.15s ease 0s;">

        <div class="card-header">
            <h3 class="card-title">
                Ajustes de Entrada y Salida
            </h3>
            <div class="card-tools">
                Tienda: {{ $empresa }}
            </div>
        </div>

        <div class="card-body">


            @if($ajuste_id)
                <div class="row col-12 mb-2">
                    <div class="col-2">
                        <label>Código:</label>
                    </div>
                    <div class="col-5 mb-2">
                        <span class="border badge-pill">{{ $ajuste_codigo }}</span>
                    </div>
                    <div class="col-2 text-md-right">
                        <label>Fecha:</label>
                    </div>
                    <div class="col-3">
                        <span class="border badge-pill">{{ verFecha($ajuste_fecha, 'd/m/Y h:i a') }}</span>
                    </div>
                </div>

                <div class="row col-12 mb-2">
                    <div class="col-2">
                        <label>Descripción:</label>
                    </div>
                    <div class="col-10">
                        <span class="border badge-pill">{{ $ajuste_descripcion }}</span>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card card-navy card-outline card-tabs">
                        <div class="card-header p-0 pt-1 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#tabs_datos_basicos" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">Detalles</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-three-tabContent">
                                <div class="tab-pane fade active show" id="tabs_datos_basicos" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">


                                    <div class="row table-responsive p-0">
                                        <form wire:submit="savePrecios" xmlns:wire="http://www.w3.org/1999/xhtml">
                                            <table class="table">
                                                <thead>
                                                <tr class="text-navy">
                                                    <th style="width: 5%">#</th>
                                                    <th>Tipo</th>
                                                    <th>Articulo</th>
                                                    <th>Descripción</th>
                                                    <th>Almacen</th>
                                                    <th>Unidad</th>
                                                    <th class="text-right">Cantidad</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @php($i = 0)
                                                @if($listarDetalles)
                                                    @foreach($listarDetalles as $detalle)
                                                        <tr>
                                                            <td>{{ $i + 1 }}</td>
                                                            <td>{{ $detalle->tipo->codigo }}</td>
                                                            <td>{{ $detalle->articulo->codigo }}</td>
                                                            <td>{{ $detalle->articulo->descripcion }}</td>
                                                            <td>{{ $detalle->almacen->codigo }}</td>
                                                            <td>{{ $detalle->unidad->codigo }}</td>
                                                            <td class="text-right">
                                                                @if($detalle->tipo->tipo == 2)
                                                                    <span>-</span>
                                                                @endif
                                                                {{ formatoMillares($detalle->cantidad, 3) }}
                                                            </td>
                                                        </tr>
                                                        @php($i++)
                                                    @endforeach
                                                @endif
                                                </tbody>
                                            </table>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            @endif


        </div>

    </div>



@endsection

