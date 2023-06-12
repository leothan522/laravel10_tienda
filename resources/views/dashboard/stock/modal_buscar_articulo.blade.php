<div wire:ignore.self class="modal fade" id="modal-buscar-articulo" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Buscar Articulos</h5>
                <button type="button" {{--wire:click="limpiar()"--}} class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row justify-content-center">
                    <div class="col-md-6 justify-content-end">
                        <form wire:submit.prevent="buscarAjustesArticulos">
                            <div class="input-group close">
                                <input type="search" class="form-control" placeholder="Buscar"
                                       wire:model.defer="keywordAjustesArticulos">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="row mt-2 table-responsive p-0" style="height: 310px;">
                    <table class="table table-head-fixed table-hover text-nowrap">
                        <thead>
                        <tr class="text-navy">
                            <th style="width: 10%">Código</th>
                            <th>Descripción</th>
                            <th style="width: 5%;">&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!is_null($ajusteListarArticulos))
                            @foreach($ajusteListarArticulos as $articulo)
                                <tr>
                                    <td>{{ $articulo->codigo }}</td>
                                    <td>{{ $articulo->descripcion }}</td>
                                    <td class="justify-content-end">
                                        <div class="btn-group">
                                            <button wire:click="selectArticuloAjuste('{{ $articulo->codigo }}')"
                                                    class="btn btn-primary btn-sm" data-dismiss="modal">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>

            </div>

            {!! verSpinner() !!}

            <div class="modal-footer">
                <div class="row col-12">
                    <div class="col-md-6">
                        <span>
                            Item: <strong>{{ $ajusteItem + 1  }}</strong>
                        </span>
                    </div>
                    <div class="col-md-6 text-right p-0">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">{{ __('Close') }}</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>