<form wire:submit.prevent="saveAjustes" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="row col-12 mb-2">
        <div class="col-md-2">
            <label>Código:</label>
        </div>
        <div class="col-md-2 mb-2">
            <input type="text" class="form-control form-control-sm @error('ajuste_codigo') is-invalid @enderror"
                   placeholder="Código" wire:model.defer="ajuste_codigo" @if(!$proximo_codigo['editable']) readonly @endif>
        </div>
        <div class="col-md-3">
            &nbsp;
        </div>
        <div class="col-md-2 text-md-right">
            <label>Fecha:</label>
        </div>
        <div class="col-md-3">
            <input type="date" class="form-control form-control-sm @error('ajuste_fecha') is-invalid @enderror"
                   wire:model.defer="ajuste_fecha" @if(!$proximo_codigo['editable_fecha']) readonly @endif>
        </div>
    </div>

    <div class="row col-12 mb-2">
        <div class="col-md-2">
            <label>Descripción:</label>
        </div>
        <div class="col-md-10">
            <input type="text" class="form-control form-control-sm @error('ajuste_descripcion') is-invalid @enderror"
                   placeholder="Descripción" wire:model.defer="ajuste_descripcion">
        </div>
    </div>

    <div class="col-12">
        <div class="card card-navy card-outline card-tabs">
            <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill"
                           href="#tabs_datos_basicos" role="tab" aria-controls="custom-tabs-three-home"
                           aria-selected="true">Detalles</a>
                    </li>
                    <div class="card-tools p-2">
                        <div class="btn-tool">
                            <button type="button" wire:click="btnContador('add')" class="btn btn-default btn-sm">
                                <i class="fas fa-plus"></i>
                            </button>
                            <button type="button" wire:click="btnContador('remove')" class="btn btn-default btn-sm"
                                    @if($ajuste_contador == 1) disabled @endif>
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-three-tabContent">
                    <div class="tab-pane fade active show" id="tabs_datos_basicos" role="tabpanel"
                         aria-labelledby="custom-tabs-three-home-tab">


                        <div class="row table-responsive p-0">

                            <table class="table">
                                <thead>
                                <tr class="text-navy">
                                    <th style="width: 5%">#</th>
                                    <th>Tipo</th>
                                    <th>Articulo</th>
                                    <th>Descripción</th>
                                    <th>Almacen</th>
                                    <th>Unidad</th>
                                    <th>Cantidad</th>
                                </tr>
                                </thead>
                                <tbody>
                                @for($i = 0; $i < $ajuste_contador; $i++)
                                    <tr>
                                        <th scope="row">
                                            <span>{{ $i + 1 }}</span>
                                        </th>
                                        <td>
                                            <input type="text" class="form-control form-control-sm {{ $classTipo[$i] }}
                                            @error('ajusteTipo.'.$i) is-invalid @enderror" wire:model.lazy="ajusteTipo.{{ $i }}" placeholder="código">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm {{ $classArticulo[$i] }}
                                            @error('ajusteArticulo.'.$i) is-invalid @enderror" wire:model.lazy="ajusteArticulo.{{ $i }}"
                                                   data-toggle="tooltip" data-placement="bottom" title="{{ $ajusteArticulo[$i] }}" placeholder="código">
                                        </td>
                                        <td>
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend" wire:click="itemTemporalAjuste({{ $i }})"
                                                     data-toggle="modal" data-target="#modal-buscar-articulo" style="cursor: pointer">
                                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                                </div>
                                                <input type="text" class="form-control form-control-sm"
                                                       data-toggle="tooltip" data-placement="bottom" title="{{ $ajusteDescripcion[$i] }}"
                                                       wire:model="ajusteDescripcion.{{ $i }}" placeholder="Descripción"
                                                       readonly>
                                            </div>

                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm {{ $classAlmacen[$i] }} @error('ajusteAlmacen.'.$i) is-invalid @enderror"
                                                   wire:model.lazy="ajusteAlmacen.{{ $i }}" placeholder="código">
                                        </td>
                                        <td>
                                            <select class="form-control form-control-sm
                                            @error('ajusteUnidad.'.$i) is-invalid @enderror" wire:model.defer="ajusteUnidad.{{ $i }}">
                                                @foreach($selectUnidad[$i] as $unidad)
                                                    <option value="{{ $unidad['id'] }}">{{ $unidad['codigo'] }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm
                                            @error('ajusteCantidad.'.$i) is-invalid @enderror" min="0.001" step=".001"
                                            wire:model.defer="ajusteCantidad.{{ $i }}">
                                        </td>
                                    </tr>
                                @endfor
                                </tbody>
                            </table>

                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-8">
                                    {{--@error('ajusteTipo.*')
                                    <span class="col-sm-12 text-sm text-bold text-danger">
                                        <i class="icon fas fa-exclamation-triangle"></i>
                                        {{ $message }}
                                    </span>
                                    @enderror--}}
                                    @if($errors->has('ajusteTipo.*') || $errors->has('ajusteArticulo.*') || $errors->has('ajusteUnidad.*') || $errors->has('ajusteCantidad.*'))
                                        <span class="col-sm-12 text-sm text-bold text-danger">
                                            <i class="icon fas fa-exclamation-triangle"></i>
                                            Todos los campos son obigatorios y deben ser validados.
                                            {{--<br>{{ var_export($errors->messages()) }}--}}
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-4 float-right">
                                    <button type="submit" class="btn btn-block btn-success">
                                        <i class="fas fa-save"></i> Guardar
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{--<div class="row">
                            Variable: {{ var_export($ajusteCantidad) }}
                        </div>--}}

                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</form>
@include('dashboard.stock.modal_buscar_articulo')