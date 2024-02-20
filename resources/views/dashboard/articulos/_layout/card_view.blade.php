<div class="card card-navy" style="height: inherit; width: inherit; transition: all 0.15s ease 0s;"
     xmlns:wire="http://www.w3.org/1999/xhtml">

    <div class="card-header">
        <h3 class="card-title">
            @if($new_articulo)
                Nuevo Articulo
            @endif
            @if(!$new_articulo && $view == 'form')
                Editar Articulo
            @endif
            @if($view != "form")
                Ver Articulo
            @endif
        </h3>
        <div class="card-tools">
            {{--<span class="btn btn-tool"><i class="fas fa-list"></i></span>--}}
            @if($nuevo)
                <button class="btn btn-tool" wire:click="create"
                        @if(!comprobarPermisos('articulos.create')) disabled @endif ><i class="fas fa-file"></i> Nuevo
                </button>
            @endif
            @if($edit)
                <button class="btn btn-tool" wire:click="btnEditar"
                        @if(!comprobarPermisos('articulos.edit')) disabled @endif ><i class="fas fa-edit"></i> Editar
                </button>
            @endif
            @if($cancelar)
                <button class="btn btn-tool" wire:click="btnCancelar"><i class="fas fa-ban"></i> Cancelar</button>
            @endif
        </div>
    </div>

    <div class="card-body">

        @include('dashboard.articulos._layout.show')
        @include('dashboard.articulos._layout.form')
        @if($view != 'form' && $view != 'show')
            <div class="row m-5">
                Debes seleccionar un Articulo ó Precionar el boton Nuevo para empezar...
            </div>
        @endif
        <div class="row @if($imagen) d-block @else d-none @endif">
            @livewire('dashboard.articulos-imagenes-component')
        </div>
        <div class="row @if($existencias) d-block @else d-none @endif">
            @livewire('dashboard.articulos-existencias-component')
        </div>
        <div>
            @livewire('dashboard.articulos-unidades-component')
            @livewire('dashboard.articulos-precios-component')
            @livewire('dashboard.articulos-identificadores-component')
            @include('dashboard.articulos._layout.modal_reportes')
        </div>

        {{--@include('dashboard.articulos.view_show')
        @include('dashboard.articulos.view_form')
        @include('dashboard.articulos.view_unidad')
        @include('dashboard.articulos.view_precios')
        @include('dashboard.articulos.view_identificadores')
        @include('dashboard.articulos.view_existencias')
        @include('dashboard.articulos.view_imagen')--}}

    </div>

    <div class="card-footer text-center @if(!$footer) d-none @endif">

        <button type="button" class="btn btn-default btn-sm" wire:click="btnUnidad" onclick="verArticulosUnidad()"
                data-toggle="modal" data-target="#modal-sm-articulos-unidades" id="button_card_view_unidad"
                @if(!$estatus) disabled @endif>
            <i class="fas fa-weight-hanging"></i> Unidad
        </button>

        <button type="button" class="btn btn-default btn-sm" wire:click="btnPrecios" onclick="verArticulosPrecios()"
                data-toggle="modal" data-target="#modal-sm-articulos-precios"
                @if(!$estatus) disabled @endif>
            <i class="fas fa-money-bill-wave"></i> Precios
        </button>

        <button type="button" class="btn btn-default btn-sm" wire:click="btnIdentificadores" onclick="verArticulosIdentificadores()"
                data-toggle="modal" data-target="#modal-sm-articulos-identificadores"
                @if(!$estatus) disabled @endif>
            <i class="fas fa-barcode"></i> Identificadores
        </button>

        <button type="button" class="btn btn-default btn-sm" wire:click="btnExistencias"
                @if(!$estatus) disabled @endif>
            <i class="fas fa-boxes"></i> Existencias
        </button>

        <button type="button" class="btn btn-default btn-sm" wire:click="btnImagen"
                @if(!$estatus) disabled @endif>
            <i class="fas fa-image"></i> Imagen
        </button>

        <button type="button" class="btn btn-default btn-sm" wire:click="btnActivoInactivo"
                @if(!comprobarPermisos('articulos.estatus')) disabled @endif >
            @if($estatus)
                <i class="fas fa-check"></i> Activo
            @else
                <i class="fas fa-ban"></i> Inactivo
            @endif
        </button>

        <button type="button" class="btn btn-default btn-sm" wire:click="destroy()"
                @if(!comprobarPermisos()) disabled @endif>
            <i class="fas fa-trash-alt"></i> Borrar
        </button>

    </div>

    <div class="overlay-wrapper" wire:loading
         wire:target="limpiarArticulos, create, save, showArticulos, destroy, btnCancelar, btnEditar,
         btnActivoInactivo, btnImagen, btnExistencias">
        <div class="overlay">
            <div class="spinner-border text-navy" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>

    <div class="overlay-wrapper d-none cargar_articulos">
        <div class="overlay">
            <div class="spinner-border text-navy" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>

</div>
