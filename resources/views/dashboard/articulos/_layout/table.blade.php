<div class="card card-navy" xmlns:wire="http://www.w3.org/1999/xhtml">

    <div class="card-header">
        <h3 class="card-title">
            @if($keyword)
                Resultados de la Búsqueda { <b class="text-warning">{{ $keyword }}</b> }
                <button class="btn btn-tool text-warning" wire:click="cerrarBusqueda"><i class="fas fa-times-circle"></i>
                </button>
            @else
                Artículos Registrados [ <b class="text-warning">{{ $rowsArticulos }}</b> ]
            @endif
        </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" wire:click="setLimit" @if($rows > $listarArticulos->count()) disabled @endif>
                <i class="fas fa-sort-amount-down-alt"></i> Ver más
            </button>
        </div>
    </div>

    <div class="card-body table-responsive p-0" @if($tableStyle) style="height: 76vh;" @endif >

        <table class="table table-head-fixed table-hover text-nowrap sticky-top">
            <thead>
            <tr class="text-navy">
                <th style="width: 10%">Código</th>
                <th>
                    Descripción
                    <small class="float-right">Mostrando {{ $listarArticulos->count() }}</small>
                </th>
            </tr>
            </thead>
        </table>

        <!-- TO DO List -->
        <ul class="todo-list" data-widget="todo-list">
            @if($listarArticulos->isNotEmpty())
                @foreach($listarArticulos as $articulo)
                    <li class=" @if(!$articulo->estatus) done @endif @if($articulo->id == $articulos_id) text-warning @endif "" >
                    <!-- todo text -->
                    <span class="text" >
                            {{ $articulo->codigo }}
                        </span>
                    <!-- Emphasis label -->
                    <small class="badge {{--badge-danger--}}">
                        {{ $articulo->descripcion }}
                    </small>
                    <!-- General tools such as edit or delete-->
                    <div class="tools text-primary" wire:click="showArticulos({{ $articulo->id }})">
                        <i class="fas fa-eye"></i>
                    </div>
                    </li>
                @endforeach
            @else
                <li class="text-center">
                    <!-- todo text -->
                    @if($keyword)
                        <span class="text">Sin resultados</span>
                    @else
                        <span class="text">Sin registros guardados</span>
                    @endif
                </li>
            @endif

        </ul>
        <!-- /.TO DO List -->

    </div>

    <div class="overlay-wrapper" wire:loading
         wire:target="save, destroy, setLimit">
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

