@if($ajuste_id)
    <div class="row col-12 mb-2">
        <div class="col-md-2">
            <label>Código:</label>
        </div>
        <div class="col-md-5 mb-2">
            <span class="border badge-pill">hola</span>
        </div>
        <div class="col-md-2 text-md-right">
            <label>Fecha:</label>
        </div>
        <div class="col-md-3">
            <span class="border badge-pill">21/12/2023</span>
        </div>
    </div>

    <div class="row col-12 mb-2">
        <div class="col-md-2">
            <label>Descripción:</label>
        </div>
        <div class="col-md-10">
            <span class="border badge-pill">ajuste por inventario inicial</span>
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
                            <form wire:submit.prevent="savePrecios" xmlns:wire="http://www.w3.org/1999/xhtml">
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
                                        <th style="width: 5%;">&nbsp;</th>
                                    </tr>
                                    </thead>
                                    {{--<tbody>
                                    @php($i = 0)
                                    @foreach($listarPrecios as $precio)
                                        @php($i++)
                                        @if(comprobarAccesoEmpresa($precio->empresa->permisos, auth()->id()))
                                            <tr>
                                                <th scope="row">
                                                    <span>{{ $i }}</span>
                                                </th>
                                                <td>
                                                    <span>{{ $precio->empresa->nombre }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ $precio->moneda }}</span>
                                                </td>
                                                <td class="text-right">
                                                    <span> {{ formatoMillares($precio->precio, 2) }}</span>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" wire:click="editarPrecio({{ $precio->id }})" class="btn btn-primary btn-sm">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach

                                    <tr class="table-sm @if(!$precio_form) d-none @endif">
                                        <td colspan="5">&nbsp;</td>
                                    </tr>

                                    <tr class="table-primary @if(!$precio_form) d-none @endif">
                                        <th scope="row">
                                <span>
                                    @if($precio_id)
                                        {{ $precio_id }}
                                    @else
                                        {{ $listarPrecios->count() + 1  }}
                                    @endif
                                </span>
                                            <input type="hidden" wire:model="precio_id" />
                                        </th>
                                        <td>
                                            <div class="form-group">
                                                <div wire:ignore>
                                                    <div class="input-group">
                                                        <select id="select_precios_empresas"></select>
                                                    </div>
                                                </div>
                                                @error('precio_empresas_id')
                                                <span class="col-sm-12 text-sm text-bold text-danger">
                                        <i class="icon fas fa-exclamation-triangle"></i>
                                        {{ $message }}
                                    </span>
                                                @enderror
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <select class="custom-select" wire:model.defer="precio_moneda">
                                                    <option value="">Seleccione</option>
                                                    <option value="Bolivares">Bolivares</option>
                                                    <option value="Dolares">Dolares</option>
                                                </select>
                                                @error('precio_moneda')
                                                <span class="col-sm-12 text-sm text-bold text-danger">
                                        <i class="icon fas fa-exclamation-triangle"></i>
                                        {{ $message }}
                                    </span>
                                                @enderror
                                            </div>
                                        </td>
                                        <td class="text-right">
                                            <div class="form-group">
                                                <input type="number" class="form-control" wire:model.defer="precio_precio" placeholder="Precio" min="0.01" step=".01">
                                                @error('precio_precio')
                                                <span class="col-sm-12 text-sm text-bold text-danger">
                                        <i class="icon fas fa-exclamation-triangle"></i>
                                        {{ $message }}
                                    </span>
                                                @enderror
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    <i class="fas fa-save"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    </tbody>--}}
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