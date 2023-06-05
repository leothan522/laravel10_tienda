<div wire:ignore.self class="modal fade" id="modal-lg-stock" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Tienda: <span class="text-bold">{{ $getStock->empresa->nombre ?? '' }}</span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                                            <img class="img-thumbnail" src="{{ asset(verImagen($getStock->articulo->detail ?? '')) }}" {{--width="101" height="100"--}}  alt="Logo Tienda"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="callout callout-success">
                                            <label class="col-12"><span class="text-muted">Vendidos:</span><span class="float-right text-bold">{{ formatoMillares($getStock->vendido ?? 0, 3) }} {{ $getStock->articulo->unidad->codigo ?? '' }}</span></label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6">

                                <h3 class="col-12 my-3">{{ $getStock->articulo->descripcion ?? '' }}</h3>
                                <label class="col-12"><span class="text-muted">Codigo:</span>&nbsp;&nbsp;{{ $getStock->articulo->codigo ?? '' }}</label>
                                <label class="col-12"><span class="text-muted">Categoria:</span>&nbsp;&nbsp;{{ $getStock->articulo->categoria->nombre ?? '' }}</label>
                                <label class="col-12"><span class="text-muted">Unidad Primaria:</span>&nbsp;&nbsp;{{ $getStock->articulo->unidad->codigo ?? '' }}</label>

                                <hr>

                                <label class="col-md-12"><span class="text-muted">Tipo:</span>&nbsp;&nbsp;{{ $getStock->articulo->tipo->nombre ?? '' }}</label>
                                <label class="col-md-12"><span class="text-muted">Procedencia:</span>&nbsp;&nbsp;{{ $getStock->articulo->procedencia->nombre ?? '' }}</label>
                                <label class="col-md-12">
                                    <span class="text-muted">I.V.A.:</span>&nbsp;&nbsp;
                                    {{ $getStock->articulo->tributario->codigo ?? '' }}
                                    ({{ intval($getStock->articulo->tributario->taza ?? 0) }}%)
                                </label>
                                <label class="col-md-12">
                                    <span class="text-muted">Estatus:</span>
                                    <button type="button" class="btn" wire:click="setEstatus({{ $getStock->id ?? null }}, {{ true }})" @if((($getStock->dolares ?? false) || ($getStock->bolivares ?? false)) && ($getStock->activo ?? false)) @else disabled @endif>
                                        @if(($getStock->estatus ?? false) && (($getStock->dolares ?? false) || ($getStock->bolivares ?? false)) && ($getStock->activo ?? false))
                                            <i class="fas fa-globe text-success"></i> Publicado
                                        @else
                                            <i class="fas fa-eraser text-muted"></i> Borrador
                                        @endif
                                    </button>
                                </label>

                                <hr>

                                <label class="col-md-12"><span class="text-muted">Marca:</span>&nbsp;&nbsp;{{ $getStock->articulo->marca ?? '' }}</label>
                                <label class="col-md-12"><span class="text-muted">Modelo:</span>&nbsp;&nbsp;{{ $getStock->articulo->modelo ?? '' }}</label>
                                <label class="col-md-12"><span class="text-muted">Referencia:</span>&nbsp;&nbsp;{{ $getStock->articulo->referencia ?? '' }}</label>

                            </div>

                        </div>

                        <div class="row">
                            <div class="table-responsive p-0">
                                <table class="table {{--table-head-fixed--}} table-hover text-nowrap">
                                    <thead>
                                    <tr class="text-navy">
                                        <th>Almacen</th>
                                        <th>Actual</th>
                                        <th>Comprom.</th>
                                        <th>Disponible</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>ALMP</td>
                                        <td>999.999,999</td>
                                        <td>999.999,999</td>
                                        <td>999.999,999</td>
                                    </tr>
                                    <tr>
                                        <td>ALMP</td>
                                        <td>999.999,999</td>
                                        <td>999.999,999</td>
                                        <td>999.999,999</td>
                                    </tr>
                                    <tr>
                                        <td>ALMP</td>
                                        <td>999.999,999</td>
                                        <td>999.999,999</td>
                                        <td>999.999,999</td>
                                    </tr>
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
