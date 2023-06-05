<div class="card {{--card-outline--}} card-navy" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="card-header">
        <h3 class="card-title">
            {{ $title }}
        </h3>

        <div class="card-tools">
            @if($btn_cancelar)
                @if($empresa_id) @php($x = $empresa_id) @else @php($x = $empresa_default) @endif
                <button type="button" class="btn btn-tool" wire:click="show({{ $x }})">
                    <i class="fas fa-ban"></i> Cancelar
                </button>
            @endif
        </div>
    </div>
    <div class="card-body">

        @include('dashboard.empresas.'.$view)

    </div>

    {!! verSpinner() !!}

    @if($footer)
        <div class="card-footer text-center @if(!comprobarAccesoEmpresa($permisos, auth()->id())) d-none @endif">

            @if(!$verDefault)
                <button type="button" class="btn btn-default btn-sm mr-1"
                        wire:click="convertirDefault({{ $empresa_id }})"
                        @if(!comprobarPermisos('empresas.edit')) disabled @endif>
                    <i class="fas fa-certificate"></i> Convertir en Default
                </button>
            @endif

            <button type="button" class="btn btn-default btn-sm" wire:click="verHorario"
                    @if(!comprobarPermisos('empresas.horario')) disabled @endif>
                <i class="fas fa-clock"></i> Horario
            </button>

            <button type="button" class="btn btn-default btn-sm" wire:click="edit"
                    @if(!comprobarPermisos('empresas.edit')) disabled @endif>
                <i class="fas fa-edit"></i> {{ __('Edit') }} Información
            </button>
                @if(!$verDefault)
                    <button type="button" class="btn btn-default btn-sm" wire:click="destroy({{ $empresa_id }})"
                            @if(!comprobarPermisos('empresas.destroy')) disabled @endif>
                        <i class="fas fa-trash-alt"></i> Borrar Empresa
                    </button>
                @endif

        </div>
    @endif
</div>
