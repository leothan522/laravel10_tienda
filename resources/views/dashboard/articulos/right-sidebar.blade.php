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
        <li class="nav-item">
            <button type="button" class="btn btn-primary btn-sm btn-block m-1"
                    data-toggle="modal" data-target="#modal-user-permisos"
                {{--onclick="verRoles({{ $parametro->id }})" id="set_rol_id_{{ $parametro->id }}"--}}>
                Tributarios
            </button>
        </li>
        <li class="dropdown-divider"></li>
    </ul>
</div>
