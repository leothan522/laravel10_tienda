<div class="row col-12 mb-2" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="col-md-2">
        <label>Código:</label>
    </div>
    <div class="col-md-5 mb-2">
        <span class="border badge-pill">{{ $articulo_codigo }}</span>
    </div>
    <div class="col-md-2 text-md-right">
        <label>Fecha:</label>
    </div>
    <div class="col-md-3">
        <span class="border badge-pill">{{ verFecha($articulo_fecha) }}</span>
    </div>
</div>

<div class="row col-12 mb-2">
    <div class="col-md-2">
        <label>Descripción:</label>
    </div>
    <div class="col-md-10">
        <span class="border badge-pill">{{ $articulo_descripcion }}</span>
    </div>
</div>

<div class="col-12">
    <div class="card card-navy card-outline card-tabs">
        <div class="card-header p-0 pt-1 border-bottom-0">
            <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#tabs_datos_basicos" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">Identificadores</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="custom-tabs-three-tabContent">
                <div class="tab-pane fade active show" id="tabs_datos_basicos" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">


                    <div class="row table-responsive p-0">
                        <form wire:submit.prevent="saveIdentificadores" xmlns:wire="http://www.w3.org/1999/xhtml">
                        <table class="table">
                        <thead>
                                <tr class="text-navy">
                                    <th style="width: 10%">#</th>
                                    <th style="width: 60%">Serial</th>
                                    <th style="width: 25%" class="text-right">Cantidad</th>
                                    <th style="width: 5%;">&nbsp;</th>
                                </tr>
                                </thead>
                            <tbody>
                            @php($i = 0)
                            @foreach($listarIdentificadores as $artiden)
                                @php($i++)
                                <tr>
                                    <th scope="row">
                                        <span>{{ $i }}</span>
                                    </th>
                                    <td>
                                        <span>{{ $artiden->serial }}</span>
                                    </td>
                                    <td class="text-right">
                                        <span> {{ formatoMillares($artiden->cantidad, 3) }}</span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" wire:click="editarIdentificador({{ $artiden->id }})" class="btn btn-primary btn-xs"
                                                    @if(!comprobarPermisos('articulos.identificadores')) disabled @endif >
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <button type="button" wire:click="borrarIdentificador({{ $artiden->id }})" class="btn btn-primary btn-xs"
                                                    @if(!comprobarPermisos('articulos.identificadores')) disabled @endif >
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            <tr class="table-sm">
                                <td colspan="4">&nbsp;</td>
                            </tr>

                            <tr class="table-primary">
                                <th scope="row">
                                    <span>
                                        @if($identificador_id)
                                            {{ $identificador_id }}
                                        @else
                                            {{ $listarIdentificadores->count() + 1  }}
                                        @endif
                                    </span>
                                    <input type="hidden" placeholder="identificadores_id" wire:model="identificador_id" />
                                </th>
                                <td>
                                    <div class="form-group">
                                        <input type="text" class="form-control" wire:model.defer="identificador_serial" placeholder="Serial del articulo">
                                        @error('identificador_serial')
                                        <span class="col-sm-12 text-sm text-bold text-danger">
                                            <i class="icon fas fa-exclamation-triangle"></i>
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </td>
                                <td class="text-right">
                                    <div class="form-group">
                                    <input type="number" class="form-control" wire:model.defer="identificador_cantidad" placeholder="Cantidad" min="0.001" step=".001">
                                        @error('identificador_cantidad')
                                        <span class="col-sm-12 text-sm text-bold text-danger">
                                            <i class="icon fas fa-exclamation-triangle"></i>
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button type="submit" class="btn btn-success btn-sm"
                                                @if(!comprobarPermisos('articulos.identificadores')) disabled @endif >
                                            <i class="fas fa-save"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

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
