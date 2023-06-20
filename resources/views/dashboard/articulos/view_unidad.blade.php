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
                    <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#tabs_datos_basicos" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">Unidad</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="custom-tabs-three-tabContent">
                <div class="tab-pane fade active show" id="tabs_datos_basicos" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">


                    <div class="row table-responsive p-0">
                        <form wire:submit.prevent="saveUnidades" xmlns:wire="http://www.w3.org/1999/xhtml">
                        <table class="table">
                            <tbody>
                            <tr>
                                <th scope="row" style="width: 10%">Primaria:</th>
                                <td style="width: 10%">
                                    <span>{{ $articulo_unidad_code }}</span>
                                </td>
                                <td>
                                    <span class="">{{ $articulo_unidad }}</span>
                                </td>
                                <td style="width: 5%;">
                                    @if($btn_und_editar)
                                        <button type="button"  class="btn btn-xs btn-primary" wire:click="btnEditarUnidad"
                                        @if(!comprobarPermisos('articulos.unidades')) disabled @endif >
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                            @php($i = 0)
                            @foreach($listarSecundarias as $artund)
                                @php($i++)
                                <tr>
                                    <th scope="row" style="width: 10%">
                                        <span class="text-muted">Secundaria[{{ $i }}]:</span>
                                    </th>
                                    <td style="width: 10%">
                                        <span>{{ $artund->unidad->codigo }}</span>
                                    </td>
                                    <td>
                                        <span class="">{{ $artund->unidad->nombre }}</span>
                                    </td>
                                    <td style="width: 5%;">
                                        <button type="button"  class="btn btn-xs btn-primary"
                                                wire:click="btnEliminarUnidad({{ $artund->id }})"
                                                @if(!comprobarPermisos('articulos.unidades')) disabled @endif >
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach

                            <tr class="table-sm @if(!$btn_und_form) d-none @endif">
                                <td colspan="4">&nbsp;</td>
                            </tr>

                            <tr class="table-primary @if(!$btn_und_form) d-none @endif">
                                <td class="text-center">
                                    <label>Primaria:</label>
                                </td>
                                <td colspan="2">
                                    <div class="form-group">
                                        <div wire:ignore>
                                            <div class="input-group">
                                                <select id="select_articulos_unidades"></select>
                                            </div>
                                        </div>
                                        @error('articulo_unidades_id')
                                        <span class="col-sm-12 text-sm text-bold text-danger">
                                            <i class="icon fas fa-exclamation-triangle"></i>
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </td>
                                <td style="width: 5%;">
                                    <button type="submit"  class="btn btn-success  btn-sm"
                                            @if(!comprobarPermisos('articulos.unidades')) disabled @endif >
                                        <i class="fas fa-save"></i>
                                    </button>
                                </td>
                            </tr>


                            <tr class="table-sm @if(!$secundaria) d-none @endif">
                                <td colspan="4">&nbsp;</td>
                            </tr>

                            <tr class="table-secondary @if(!$secundaria) d-none @endif">
                                <td class="text-center">
                                    <label>Secundaria:</label>
                                </td>
                                <td colspan="2">
                                    <div class="form-group">
                                        <div wire:ignore>
                                            <div class="input-group">
                                                <select id="select_unidades_artund"></select>
                                            </div>
                                        </div>
                                        @error('artund_unidades_id')
                                        <span class="col-sm-12 text-sm text-bold text-danger">
                                            <i class="icon fas fa-exclamation-triangle"></i>
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </td>
                                <td style="width: 5%;">
                                    <button type="submit"  class="btn btn-success  btn-sm"
                                            @if(!comprobarPermisos('articulos.unidades')) disabled @endif >
                                        <i class="fas fa-save"></i>
                                    </button>
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
