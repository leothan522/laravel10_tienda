<div class="card {{--card-outline--}} card-navy" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="card-header">
        <h3 class="card-title">
            Tiendas
        </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" wire:click="create" @if(!comprobarPermisos('empresas.create')) disabled @endif>
                <i class="fas fa-file"></i> Nuevo
            </button>
        </div>
    </div>
    <div class="card-body table-responsive p-0" {{--style="height: 400px;"--}}>
        <table class="table {{--table-head-fixed--}} table-hover text-nowrap">
            {{--<thead>
            <tr class="text-navy">
                <th>Nombre</th>
                <th style="width: 5%;">&nbsp;</th>
            </tr>
            </thead>--}}
            <tbody>
            @if($tiendas->isNotEmpty())
                @foreach($tiendas as $tienda)
                    <tr class="@if($empresa_id == $tienda->id) table-primary @endif">
                        <td>
                            <button type="button" class="btn @if($empresa_id == $tienda->id) text-bold @endif"
                                    wire:click="show({{ $tienda->id }})">
                                 @if($tienda->default) <i class="fas fa-certificate text-muted text-xs"></i> @endif {{ $tienda->nombre }}
                            </button>
                        </td>
                        <td class="justify-content-center pt-3" style="width: 5%;">
                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input type="checkbox" class="custom-control-input" id="customSwitchIdL_{{ $tienda->id }}"
                                    @if(estatusTienda($tienda->id, true)) checked @endif
                                       wire:click="estatusTienda({{ $tienda->id }})" @if(!comprobarPermisos('empresas.estatus') || !comprobarAccesoEmpresa($tienda->permisos, auth()->id())) disabled @endif>
                                <label class="custom-control-label" for="customSwitchIdL_{{ $tienda->id }}" role="button"></label>
                            </div>
                        </td>
                    </tr>
                @endforeach
                @else
                <tr class="text-center">
                    <td colspan="2">
                        <span>Aún se se ha creado una Tienda.</span>
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
</div>
