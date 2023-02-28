<div class="card card-navy" style="height: inherit; width: inherit; transition: all 0.15s ease 0s;">

    <div class="card-header">
        <h3 class="card-title">Crear Usuario</h3>
        <div class="card-tools">
            <span class="btn btn-tool"><i class="fas fa-file"></i></span>
        </div>
    </div>

    <div class="card-body">


        <form wire:submit.prevent="save" xmlns:wire="http://www.w3.org/1999/xhtml">

            <div class="form-group">
                <label for="name">{{ __('Name') }}</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" class="form-control" wire:model.defer="name" placeholder="Nombre y Apellido">
                    @error('name')
                    <span class="col-sm-12 text-sm text-bold text-danger">
                        <i class="icon fas fa-exclamation-triangle"></i>
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="email">{{ __('Email') }}</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    </div>
                    <input type="text" class="form-control" wire:model.defer="email" placeholder="Email">
                    @error('email')
                    <span class="col-sm-12 text-sm text-bold text-danger">
                        <i class="icon fas fa-exclamation-triangle"></i>
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">{{ __('Password') }}</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    </div>
                    <input type="text" class="form-control" wire:model.defer="password" placeholder="Contraseña">
                    <span class="input-group-append">
                        <button type="button" wire:click="generarClave" class="btn btn-info btn-flat btn-sm text-sm">
                            <i class="fas fa-key"></i>
                        </button>
                    </span>
                    @error('password')
                    <span class="col-sm-12 text-sm text-bold text-danger">
                        <i class="icon fas fa-exclamation-triangle"></i>
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">{{ __('Role') }}</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user-cog"></i></span>
                    </div>
                    <select class="custom-select" wire:model.defer="role">
                        <option value="">Seleccione</option>
                        <option value="0">Estandar</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ ucwords($role->nombre) }}</option>
                        @endforeach
                        @if(comprobarPermisos())
                            <option value="1">Administrador</option>
                        @endif
                    </select>
                    @error('role')
                    <span class="col-sm-12 text-sm text-bold text-danger">
                        <i class="icon fas fa-exclamation-triangle"></i>
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-block btn-success" value="Guardar">
            </div>

        </form>


    </div>

    {!! verSpinner() !!}

</div>
