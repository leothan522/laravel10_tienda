<div class="card card-navy" style="height: inherit; width: inherit; transition: all 0.15s ease 0s;"
     xmlns:wire="http://www.w3.org/1999/xhtml">

    <div class="card-header">
        <h3 class="card-title">
            @if($nuevo)
                Nuevo Ajuste
            @endif
            @if(!$nuevo && $view == 'form')
                Editar Ajuste
            @endif
            @if($view != "form")
                Ver Ajuste
            @endif
        </h3>
        <div class="card-tools">
            {{--<span class="btn btn-tool"><i class="fas fa-list"></i></span>--}}
            @if($btn_nuevo)
                <button class="btn btn-tool" wire:click="create"
                        @if(!comprobarPermisos('ajustes.create')) disabled @endif ><i class="fas fa-file"></i> Nuevo
                </button>
            @endif
            @if($btn_editar)
                <button class="btn btn-tool" wire:click="btnEditar"
                        @if(!$ajuste_estatus || !comprobarPermisos('ajustes.edit')) disabled @endif ><i
                        class="fas fa-edit"></i> Editar
                </button>
            @endif
            @if($btn_cancelar)
                <button class="btn btn-tool" wire:click="btnCancelar"><i class="fas fa-ban"></i> Cancelar</button>
            @endif
        </div>
    </div>

    <div class="card-body">


        @if($view == 'form')
            @include('dashboard.stock.ajustes.form')
        @endif

        @if($view == 'show')
            @include('dashboard.stock.ajustes.view_show')
        @endif

        @if($view != 'form' && $view != 'show')
            <div class="row m-5">
                Debes seleccionar un Ajutes ó Precionar el boton Nuevo para empezar...
            </div>
        @endif


    </div>

    <div class="card-footer text-center @if(!$footer) d-none @endif">

        <a href="{{ route('ajustes.print', $ajuste_id) }}" target="_blank"
           class="btn btn-default btn-sm @if(!comprobarPermisos('ajustes.print') || !$ajuste_estatus) disabled @endif ">
            <i class="fas fa-print"></i> Imprimir
        </a>

        <button type="button" class="btn btn-default btn-sm" wire:click="destroy('anular')"
                @if(!comprobarPermisos('ajustes.anular') || !$ajuste_estatus) disabled @endif>
            @if(!$ajuste_estatus)
                <i class="fas fa-ban"></i> Anulado
            @else
                <i class="fas fa-ban"></i> Anular
            @endif
        </button>

        {{--<button type="button" class="btn btn-default btn-sm" wire:click="destroyAjustes()"
                @if(!comprobarPermisos() || !$ajuste_estatus) disabled @endif>
            <i class="fas fa-trash-alt"></i> Borrar
        </button>--}}

    </div>

    <div class="overlay-wrapper" wire:loading
         wire:target="setEstatus, show, limpiarAjustes, create, btnCancelar, btnEditar, btnContador, save, update, destroy, showAjustes">
        <div class="overlay">
            <div class="spinner-border text-navy" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>

    <div class="overlay-wrapper d-none cargar_ajustes">
        <div class="overlay">
            <div class="spinner-border text-navy" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>

</div>
