<div class="card card-navy" style="height: inherit; width: inherit; transition: all 0.15s ease 0s;">

    <div class="card-header">
        <h3 class="card-title">
            @if($new_ajuste) Nuevo Ajuste @endif
            @if(!$new_ajuste && $view_ajustes == 'form') Editar Ajuste @endif
            @if($view_ajustes != "form") Ver Ajuste @endif
        </h3>
        <div class="card-tools">
            {{--<span class="btn btn-tool"><i class="fas fa-list"></i></span>--}}
            @if($btn_nuevo) <button class="btn btn-tool" wire:click="createAjuste"><i class="fas fa-file"></i> Nuevo</button> @endif
            @if($btn_editar) <button class="btn btn-tool" wire:click="btnEditar"><i class="fas fa-edit"></i> Editar</button> @endif
            @if($btn_cancelar) <button class="btn btn-tool" wire:click="btnCancelar"><i class="fas fa-ban"></i> Cancelar</button> @endif
        </div>
    </div>

    <div class="card-body">


       @include('dashboard.stock.view_ajustes_'.$view_ajustes)


    </div>

    <div class="card-footer text-center @if(!$footer) d-none @endif">

        <button type="button" class="btn btn-default btn-sm" wire:click="btnUnidad"
                {{--@if(!comprobarPermisos('empresas.horario')) disabled @endif--}}>
            <i class="fas fa-print"></i> Imprimir
        </button>

        <button type="button" class="btn btn-default btn-sm" wire:click="btnActivoInactivo"
                {{--@if(!comprobarPermisos('empresas.horario')) disabled @endif--}}>
            @if(/*$articulo_estatus*/ false)
                <i class="fas fa-check"></i> Activo
            @else
                <i class="fas fa-ban"></i> Anular
            @endif
        </button>

        <button type="button" class="btn btn-default btn-sm" wire:click="destroy()"
                {{--@if(!comprobarPermisos('empresas.horario')) disabled @endif--}}>
            <i class="fas fa-trash-alt"></i> Borrar
        </button>

    </div>

    <div class="overlay-wrapper" wire:loading wire:target="empresa_id, setEstatus, show, verAjustes, limpiarAjustes, createAjuste, btnCancelar, btnEditar, btnContador, saveAjustes, showAjustes">
        <div class="overlay">
            <div class="spinner-border text-navy" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>

</div>
