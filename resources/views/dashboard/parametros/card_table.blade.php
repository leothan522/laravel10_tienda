<div class="card card-outline card-navy" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="card-header">
        <h3 class="card-title">
            @if($keyword)
                Resultados de la Busqueda { <b class="text-danger">{{ $keyword }}</b> }
                <button class="btn btn-tool text-danger" wire:click="limpiar"><i class="fas fa-times-circle"></i>
                </button>
            @else
                Parametros Registrados [ <b class="text-navy">{{ $rows }}</b> ]
            @endif
        </h3>

        <div class="card-tools">
            <ul class="pagination pagination-sm float-right m-1">
                {{ $parametros->links() }}
            </ul>
        </div>
    </div>
    <div class="card-body table-responsive p-0" {{--style="height: 400px;"--}}>
        <table class="table {{--table-head-fixed--}} table-hover text-nowrap">
            <thead>
            <tr class="text-navy">
                <th>id</th>
                <th>nombre</th>
                <th>table_id</th>
                <th>valor</th>
                <th style="width: 5%;">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            @if($parametros->isNotEmpty())
                @foreach($parametros as $parametro)
                    <tr>
                        <td class="text-bold">{{ $parametro->id }}</td>
                        <td>{{ $parametro->nombre }}</td>
                        <td>
                            @if(is_null($parametro->tabla_id))
                                null
                            @else
                                {{ $parametro->tabla_id }}
                            @endif
                        </td>
                        <td>
                            @if(is_null($parametro->valor))
                                null
                            @else
                                @if($parametro->tabla_id == "-1")
                                    json{...}
                                @else
                                    {{ $parametro->valor }}
                                @endif
                            @endif
                        </td>
                        <td class="justify-content-end">
                            <div class="btn-group">
                                <button wire:click="edit({{ $parametro->id }})" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button wire:click="destroy({{ $parametro->id }})" class="btn btn-primary btn-sm">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr class="text-center">
                    <td colspan="5">
                        @if($keyword)
                            <span>Sin resultados</span>
                        @else
                            <span>Sin registros guardados</span>
                        @endif
                    </td>
                </tr>
            @endif

            </tbody>
        </table>

    </div>
    {!! verSpinner() !!}
</div>
