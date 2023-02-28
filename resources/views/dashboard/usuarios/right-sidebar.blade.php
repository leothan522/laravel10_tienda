<div class="p-3">
    <h5>Roles de Usuarios</h5>
    <hr class="mb-2">
    <h6>Crear nuevo Rol</h6>
    <form id="from_rol">
        <div class="input-group input-group-sm">
            <input type="text" class="form-control" placeholder="nombre" id="nuevo_rol"
                   data-roles="{{ $roles->count() + 1 }}">
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
            <span class="text-small text-muted float-right">Roles Registrados [ {{ $roles->count() }} ]</span>
        </li>
        <li class="dropdown-divider"></li>
    </ul>
    <div class="col-md-12 justify-content-center" style="height: 350px; overflow-y: scroll;" id="listar_roles">
        @if($roles->isNotEmpty())
            @foreach($roles as $parametro)
                <button type="button" class="btn btn-primary btn-sm btn-block m-1"
                        data-toggle="modal" data-target="#modal-user-permisos"
                    onclick="verRoles({{ $parametro->id }})" id="set_rol_id_{{ $parametro->id }}">
                    {{ ucwords($parametro->nombre) }}
                </button>
            @endforeach
        @endif
    </div>
</div>
