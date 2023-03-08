<div class="card card-outline card-navy" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="card-header">
        <h3 class="card-title">
            @if($keywordTributarios)
                Resultados de la Busqueda { <b class="text-danger">{{ $keywordTributarios }}</b> }
                <button class="btn btn-tool text-danger" wire:click="limpiarTributarios"><i class="fas fa-times-circle"></i>
                </button>
            @else
                Registradas [ <b class="text-navy">{{ $rowsTributarios }}</b> ]
            @endif
        </h3>

        <div class="card-tools">
            <ul class="pagination pagination-sm float-right m-1">
                {{ $listarTributarios->links() }}
            </ul>
        </div>
    </div>
    <div class="card-body table-responsive p-0" style="height: 610px;">
        <table class="table table-head-fixed table-hover text-nowrap">
            <thead>
            <tr class="text-navy">
                <th style="width: 20%">Codigo</th>
                <th class="text-center">Taza (%)</th>
                <th style="width: 5%;">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            @if($listarTributarios->isNotEmpty())
                @foreach($listarTributarios as $tributario)
                    <tr>
                        <td>{{ $tributario->codigo }}</td>
                        <td class="text-center">{{ formatoMillares($tributario->taza) }} <i class="fas fa-percentage"></i></td>
                        <td class="justify-content-end">
                            <div class="btn-group">
                                <button wire:click="editTributario({{ $tributario->id }})" class="btn btn-primary btn-sm"
                                @if(!comprobarPermisos('tributarios.edit')) disabled @endif >
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button wire:click="destroyTributario({{ $tributario->id }})" class="btn btn-primary btn-sm"
                                @if(!comprobarPermisos('tributarios.destroy')) disabled @endif >
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
                @else
                <tr class="text-center">
                    <td colspan="3">
                        <span>Aún se se ha creado.</span>
                    </td>
                </tr>
            @endif

            </tbody>
        </table>
    </div>
</div>
