<li class="nav-item" xmlns:wire="http://www.w3.org/1999/xhtml">
    {{--@if(leerJson(Auth::user()->permisos, 'precio.dolar')|| Auth::user()->role == 1 || Auth::user()->role == 100)--}}
        <button class="nav-link btn btn-block" @if(comprobarPermisos('precio.dolar')) wire:click="edit({{ $editar }})" @endif>
            <span class="text-bold text-left text-primary">
                <i class="fas fa-dollar-sign"></i> Precio Dolar
            </span>
            <span class="float-right">
                @if(comprobarPermisos('precio.dolar'))
                    @if(!$editar)
                        <i class="fas fa-edit"></i>
                    @else
                        <i class="fas fa-ban"></i>
                    @endif
                @endif
            </span>
        </button>

    {{--@else
        <span class="nav-link">
            <i class="fas fa-dollar-sign"></i> Precio Dolar
        </span>
    @endif--}}
</li>
@if(!$editar)
    <li class="nav-item text-center">
        <span class="text-small text-light text-bold">{{ formatoMillares($dollar) }} Bs.</span>
    </li>
@else
    <li class="nav-item text-center" xmlns:wire="http://www.w3.org/1999/xhtml">
        <form class="row justify-content-center" wire:submit="save">
            <div class="input-group col-md-6 input-group-sm">
                <input type="text" step=".01" class="form-control text-decoration-none" wire:model="dollar" required>
                <span class="input-group-append">
                    <button type="submit" class="btn btn-success btn-flat">
                        <i class="fas fa-save"></i>
                    </button>
                  </span>
            </div>
        </form>
    </li>
@endif
{!! verSpinner() !!}
