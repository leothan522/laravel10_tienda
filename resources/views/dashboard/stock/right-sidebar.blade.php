<div class="p-3">
    <ul class="nav nav-pills flex-column">
        @livewire('dashboard.dolar-component')
        <li class="dropdown-divider"></li>
        <li class="nav-item mb-2">
            <span class="text-small text-muted float-right">Tablas</span>
        </li>
        <li class="nav-item">
            <button type="button" class="btn btn-primary btn-sm btn-block m-1"
                    data-toggle="modal" data-target="#modal-almacenes" onclick="verAlmacenes()"
                    @if(!comprobarPermisos('almacenes.index')) disabled @endif >
                Almacenes
            </button>
        </li>

        @if(auth()->user()->role == 100)
            {{--<li class="nav-item">
                <button type="button" class="btn btn-primary btn-sm btn-block m-1"
                        data-toggle="modal" data-target="#modal-procedencias" onclick="verProcedencias()"
                        @if(!comprobarPermisos('procedencias.index')) disabled @endif >
                    Procedencias
                </button>
            </li>--}}
        @endif

        <li class="dropdown-divider"></li>
    </ul>
</div>
