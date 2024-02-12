<div class="p-3">
    <h5>Roles de Usuarios</h5>
    <hr class="mb-2">
    <h6>Crear nuevo Rol</h6>
    <form id="from_role_usuario">
        <div class="input-group input-group-sm">
            <input type="text" class="form-control" placeholder="nombre" id="input_role_nombre" required>
            <span class="input-group-append">
            <button type="submit" class="btn btn-success btn-flat">
                <i class="fas fa-save"></i>
            </button>
          </span>
        </div>
    </form>
    <hr class="mb-2">
    <ul class="nav nav-pills flex-column">
        <li class="nav-item">
            <span class="text-small text-muted float-right">Roles Registrados [ <span id="span_roles_rows">{{ $listarRoles->count() }}</span> ]</span>
        </li>
        <li class="dropdown-divider"></li>
    </ul>
    <div class="col-md-12 justify-content-center" id="div_listar_roles">
        @if($listarRoles->isNotEmpty())
            @foreach($listarRoles as $parametro)
                <button type="button" class="btn btn-primary btn-sm btn-block m-1" data-toggle="modal"
                        data-target="#modal-roles-usuarios" onclick="showRol({{ $parametro->id }})" id="button_role_id_{{ $parametro->id }}">
                    {{ ucwords($parametro->nombre) }}
                </button>
            @endforeach
        @endif
    </div>
</div>
