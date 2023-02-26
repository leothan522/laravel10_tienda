<div class="card card-navy" style="height: inherit; width: inherit; transition: all 0.15s ease 0s;"
     xmlns:wire="http://www.w3.org/1999/xhtml">

    <div class="card-header">
        <h3 class="card-title">
            @if($view == "create")
                Crear Parametro
                @else
                Editar Parametro
            @endif

        </h3>
        <div class="card-tools">
            @if($view == "create")
                <span class="btn btn-tool"><i class="fas fa-file"></i></span>
                @else
                <button class="btn btn-tool text-bold" wire:click="limpiar"><i class="fas fa-ban"></i> Cancelar</button>
            @endif
        </div>
    </div>

    <div class="card-body">


        <form wire:submit.prevent="save">

            <div class="form-group">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text text-bold">nombre</span>
                    </div>
                    <input type="text" class="form-control" wire:model.defer="nombre" name="nombre"
                           placeholder="[string]">
                    @error('nombre')
                    <span class="col-sm-12 text-sm text-bold text-danger">
                        <i class="icon fas fa-exclamation-triangle"></i>
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text text-bold">tabla_id</span>
                    </div>
                    <input type="text" class="form-control" wire:model.defer="tabla_id" name="tabla_id"
                           placeholder="[integer]">
                    @error('tabla_id')
                    <span class="col-sm-12 text-sm text-bold text-danger">
                        <i class="icon fas fa-exclamation-triangle"></i>
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text text-bold">valor</span>
                    </div>
                    <input type="text" class="form-control" wire:model.defer="valor" name="valor"
                           placeholder="[string]">
                    @error('valor')
                    <span class="col-sm-12 text-sm text-bold text-danger">
                        <i class="icon fas fa-exclamation-triangle"></i>
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group text-right">
                <input type="submit" class="btn btn-block btn-success" value="Guardar @if($view == "edit") Cambios @endif">
            </div>

        </form>


    </div>

    {!! verSpinner() !!}

</div>
