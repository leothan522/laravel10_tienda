<div class="p-3">
    <ul class="nav nav-pills flex-column">
        @livewire('dashboard.dolar-component')
        <li class="dropdown-divider"></li>
        <li class="nav-item mb-2">
            <span class="text-small text-muted float-right">Tablas</span>
        </li>
        <li class="nav-item">
            <button type="button" class="btn btn-primary btn-sm btn-block m-1"
                    data-toggle="modal" data-target="#modal-categorias" onclick="verCategorias()"
            @if(!comprobarPermisos('categorias.index')) disabled @endif >
                Categorias
            </button>
        </li>
        <li class="nav-item">
            <button type="button" class="btn btn-primary btn-sm btn-block m-1"
                    data-toggle="modal" data-target="#modal-unidades" onclick="verUnidades()"
                    @if(!comprobarPermisos('unidades.index')) disabled @endif >
                Unidades
            </button>
        </li>

        @if(auth()->user()->role == 100)
            <li class="nav-item">
                <button type="button" class="btn btn-primary btn-sm btn-block m-1"
                        data-toggle="modal" data-target="#modal-procedencias" onclick="verProcedencias()"
                        @if(!comprobarPermisos('procedencias.index')) disabled @endif >
                    Procedencias
                </button>
            </li>
            <li class="nav-item">
                <button type="button" class="btn btn-primary btn-sm btn-block m-1"
                        data-toggle="modal" data-target="#modal-tributarios" onclick="verTributarios()"
                        @if(!comprobarPermisos('tributarios.index')) disabled @endif >
                    Tributarios
                </button>
            </li>
            <li class="nav-item">
            <button type="button" class="btn btn-primary btn-sm btn-block m-1"
                    data-toggle="modal" data-target="#modal-tipos" onclick="verTipos()"
                    @if(!comprobarPermisos('tipos.index')) disabled @endif >
                Tipos
            </button>
        </li>
        @endif

        <li class="dropdown-divider"></li>
    </ul>
</div>
