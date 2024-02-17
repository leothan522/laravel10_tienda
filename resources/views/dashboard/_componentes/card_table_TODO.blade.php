<div class="card card-navy" xmlns:wire="http://www.w3.org/1999/xhtml">

    <div class="card-header">
        <h3 class="card-title">
            @if(/*$keyword*/false)
                Resultados para { <b class="text-warning">{{ $keyword }}</b> }
                <button class="btn btn-tool text-warning" wire:click="showAjustes" >
                    <i class="fas fa-times-circle"></i>
                </button>
            @else
                Ajustes [Entrada y Salida]
            @endif
        </h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" wire:click="setLimit">
                <i class="fas fa-sort-amount-down-alt"></i> Ver más
            </button>
        </div>
    </div>

    <div class="card-body table-responsive p-0" style="height: 76vh;">

        <table class="table table-head-fixed table-hover text-nowrap sticky-top">
            <thead>
            <tr class="text-navy">
                <th style="width: 10%">Código</th>
                <th>Descripción</th>
            </tr>
            </thead>
        </table>

        <!-- TO DO List -->
        <ul class="todo-list" data-widget="todo-list">
            @if($listarAjustes->isNotEmpty())
                @foreach($listarAjustes as $ajuste)
                    <li class=" @if(!$ajuste->estatus) done @endif @if($ajuste->id == $ajuste_id) text-warning @endif "" >
                    <!-- todo text -->
                    <span class="text">
                            {{ $ajuste->codigo }}
                        </span>
                    <!-- Emphasis label -->
                    <small class="badge {{--badge-danger--}}">
                        {{ $ajuste->descripcion }}
                    </small>
                    <!-- General tools such as edit or delete-->
                    <div class="tools text-primary" wire:click="show({{ $ajuste->id }})">
                        <i class="fas fa-eye"></i>
                    </div>
                    </li>
                @endforeach
            @else
                <li class="text-center">
                    <!-- todo text -->
                    @if(/*$keyword*/false)
                        <span class="text">Sin resultados</span>
                    @else
                        <span class="text">Sin registros guardados</span>
                    @endif
                </li>
            @endif
            @endif

        </ul>
        <!-- /.TO DO List -->

    </div>

    <div class="overlay-wrapper" wire:loading wire:target="setLimit, save, destroy, confirmedBorrarAjuste">
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
