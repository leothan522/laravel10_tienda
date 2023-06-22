<div wire:ignore.self class="modal fade" id="modal-reportes-stock" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reporte: Stock</h5>
                <button type="button" {{--wire:click="limpiar()"--}} class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <form method="post" action="{{ route('stock.reportes') }}">
                            @csrf
                            <div class="form-group form-group-sm">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Nivel de Stock
                                        </span>
                                    </div>
                                    <select class="form-control form-control-sm" name="stock">
                                        <option value="all"></option>
                                        <option value="diferente">Diferente a 0</option>
                                        <option value="igual">Igual a 0</option>
                                        <option value="mayor">Mayor a 0</option>
                                        <option value="menor">Menor a 0</option>
                                    </select>
                                    @error('stock')
                                    <span class="col-sm-12 text-sm text-bold text-danger">
                                        <i class="icon fas fa-exclamation-triangle"></i>
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group form-group-sm">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Tipo de Stock
                                        </span>
                                    </div>
                                    <select class="form-control form-group-sm" name="tipo">
                                        <option value="all"></option>
                                        <option value="actual">Actual</option>
                                        <option value="disponible">Disponible</option>
                                        <option value="comprometido">Comprometido</option>
                                        <option value="vendido">Vendido</option>
                                    </select>
                                    @error('tipo')
                                    <span class="col-sm-12 text-sm text-bold text-danger">
                                        <i class="icon fas fa-exclamation-triangle"></i>
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group form-group-sm">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Unidad
                                        </span>
                                    </div>
                                    <select class="form-control form-group-sm" name="unidad">
                                        <option value="all"></option>
                                        <option value="1">UND</option>
                                        <option value="2">KG</option>
                                        <option value="3">CAJA</option>
                                        <option value="4">BULTO</option>
                                    </select>
                                    @error('unidad')
                                    <span class="col-sm-12 text-sm text-bold text-danger">
                                        <i class="icon fas fa-exclamation-triangle"></i>
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group form-group-sm">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Almacen
                                        </span>
                                    </div>
                                    <select class="form-control form-control-sm" name="almacen">
                                        <option value="all"></option>
                                        <option value="1">ALMP</option>
                                        <option value="2">HOLA</option>
                                    </select>
                                    @error('almacen')
                                    <span class="col-sm-12 text-sm text-bold text-danger">
                                        <i class="icon fas fa-exclamation-triangle"></i>
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-block btn-primary"
                                        @if(!comprobarPermisos('stock.reportes')) disabled @endif >
                                    <i class="fas fa-file-excel"></i> Generar Reporte
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

            {!! verSpinner() !!}

            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">{{ __('Close') }}</button>
            </div>

        </div>
    </div>
</div>
