<div wire:ignore.self class="modal fade" id="modal-lg-stock" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Tienda: <span class="text-bold">{{ $getStock['empresa'] ?? '' }}</span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="show('true')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="card card-solid">
                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-6">

                                <div class="row attachment-block p-3">
                                    <div class="col-12">
                                        <label class="col-12" for="name">
                                            Imagen
                                            <span class="badge float-right"><i class="fas fa-image"></i></span>
                                        </label>
                                    </div>
                                    <div class="row col-12 justify-content-center mb-3 mt-3">
                                        <div class="col-10">
                                            <img class="img-thumbnail"
                                                 src="{{ verImagen($getStock['imagen'] ?? null, false, true) }}"
                                                 {{--width="101" height="100"--}}  alt="Imagen Articulo"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div class="callout callout-success">
                                            <label class="col-12"><span class="text-muted">Vendidos:</span><span
                                                    class="float-right text-bold">{{ formatoMillares($getStock['vendido'] ?? 0, 3) }} {{ $getStock['unidad'] ?? '' }}</span></label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6">

                                <h3 class="col-12 my-3">{{ $getStock['articulo'] ?? '' }}</h3>

                                @if(!empty($getStock) && !$getStock['articulo_estatus'])
                                    <label class="col-12 text-center">
                                        <span class="text-danger"><i class="fas fa-ban"></i></span>
                                        <span class="text-danger">Articulo Inactivo</span>
                                    </label>
                                @endif

                                <label class="col-12"><span
                                        class="text-muted">Codigo:</span>&nbsp;&nbsp;{{ $getStock['codigo'] ?? '' }}
                                </label>
                                <label class="col-12"><span
                                        class="text-muted">Categoria:</span>&nbsp;&nbsp;{{ $getStock['categoria'] ?? '' }}
                                </label>
                                <label class="col-12"><span
                                        class="text-muted">Unidad Primaria:</span>&nbsp;&nbsp;{{ $getStock['unidad_principal'] ?? '' }}
                                </label>

                                <hr>

                                <label class="col-md-12"><span
                                        class="text-muted">Tipo:</span>&nbsp;&nbsp;{{ $getStock['tipo'] ?? '' }}
                                </label>
                                <label class="col-md-12"><span
                                        class="text-muted">Procedencia:</span>&nbsp;&nbsp;{{ $getStock['procedencia'] ?? '' }}
                                </label>
                                <label class="col-md-12">
                                    <span class="text-muted">I.V.A.:</span>&nbsp;&nbsp;
                                    {{ $getStock['tributario'] ?? '' }}
                                    ({{ intval($getStock['taza'] ?? 0) }}%)
                                </label>
                                <label class="col-md-12">
                                    <span class="text-muted">Estatus:</span>
                                    @if($getStock)
                                        @if($getStock['estatus'] && ($getStock['dolares'] || $getStock['bolivares']) && $getStock['activo'])
                                            <button type="button" class="btn" style="cursor: default;"
                                                {{--wire:click="setEstatus('{{ json_encode($getStock['existencias']) }}')"--}}>
                                                <i class="fas fa-globe text-success"></i> Publicado
                                            </button>
                                        @else
                                            <button type="button" class="btn" style="cursor: default;"
                                                    @if(($getStock['dolares'] || $getStock['bolivares']) && $getStock['activo']) {{--wire:click="setEstatus('{{ json_encode($getStock['existencias']) }}')"--}}
                                                    @else disabled @endif>
                                                <i class="fas fa-eraser text-muted"></i> Borrador
                                            </button>
                                        @endif
                                    @endif
                                </label>

                                @if($getStock && $getStock['porcentaje'] > 0 && $getStock['articulo_estatus'])
                                    <label class="col-md-12">
                                        <i class="fas fa-gifts text-primary"></i>
                                        <span
                                            class="text-primary">Oferta:</span>&nbsp;&nbsp;Descuento {{ $getStock['porcentaje'] ?? '' }}%
                                    </label>
                                    <label class="col-md-6"><span
                                            class="text-muted">Dolares:</span>&nbsp;&nbsp;${{ formatoMillares($getStock['oferta_dolares'], 2) }}
                                    </label>
                                    <label class="col-md-6"><span
                                            class="text-muted">Bolivares:</span>&nbsp;&nbsp;{{ formatoMillares($getStock['oferta_bolivares'], 2) }} Bs.
                                    </label>
                                @endif
                                <hr>

                                <label class="col-md-12"><span
                                        class="text-muted">Marca:</span>&nbsp;&nbsp;{{ $getStock['marca'] ?? '' }}
                                </label>
                                <label class="col-md-12"><span
                                        class="text-muted">Modelo:</span>&nbsp;&nbsp;{{ $getStock['modelo'] ?? '' }}
                                </label>
                                <label class="col-md-12"><span
                                        class="text-muted">Referencia:</span>&nbsp;&nbsp;{{ $getStock['referencia'] ?? '' }}
                                </label>

                            </div>

                        </div>

                        <div class="row">
                            <label class="col-md-12"><span class="text-muted">Existencias:</span>
                                <span class="float-right text-bold">{{ $getStock['unidad'] ?? '' }}</span>
                            </label>
                            <div class="table-responsive p-0">
                                <table class="table table-sm {{--table-head-fixed--}} table-hover text-nowrap">
                                    <thead>
                                    <tr class="text-navy">
                                        <th>Almacen</th>
                                        <th class="text-right">Actual</th>
                                        <th class="text-right">Comprom.</th>
                                        <th class="text-right">Disponible</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($getStock)
                                        @foreach($getStock['existencias'] as $existencia)
                                            @if($existencia->actual <= 0)
                                                @continue
                                            @endif
                                            <tr>
                                                <td>{{ $existencia->almacen }}</td>
                                                <td class="text-right">{{ formatoMillares($existencia->actual, 3) }}</td>
                                                <td class="text-right">{{ formatoMillares($existencia->comprometido, 3) }}</td>
                                                <td class="text-right">{{ formatoMillares($existencia->disponible, 3) }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>


            </div>
            <div class="modal-footer justify-content-end">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">{{ __('Close') }}</button>
            </div>
            {!! verSpinner() !!}
        </div>
    </div>
</div>
