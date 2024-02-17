<div class="card card-navy" style="height: inherit; width: inherit; transition: all 0.15s ease 0s;"
     xmlns:wire="http://www.w3.org/1999/xhtml">

    <div class="card-header">
        @if($tipos_id)
            <h3 class="card-title">Editar</h3>
            <div class="card-tools">
                <button class="btn btn-tool" wire:click="limpiarTiposAjuste">
                    <i class="fas fa-ban"></i> Cancelar
                </button>
            </div>
            @else
            <h3 class="card-title">Crear</h3>
            <div class="card-tools">
                <span class="btn btn-tool"><i class="fas fa-file"></i></span>
            </div>
        @endif
    </div>

    <div class="card-body">


        <form wire:submit="save">

            <div class="form-group">
                <label for="name">Código</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-code"></i></span>
                    </div>
                    <input type="text" class="form-control" wire:model="codigo" placeholder="Código">
                    @error('codigo')
                    <span class="col-sm-12 text-sm text-bold text-danger">
                        <i class="icon fas fa-exclamation-triangle"></i>
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="name">Descripción</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-tag"></i></span>
                    </div>
                    <input type="text" class="form-control" wire:model="nombre" placeholder="Descripción">
                    @error('nombre')
                    <span class="col-sm-12 text-sm text-bold text-danger">
                        <i class="icon fas fa-exclamation-triangle"></i>
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label>Tipo</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" wire:model.live="tipo" value="1">
                    <label class="form-check-label">Entrada</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" wire:model.live="tipo" value="2">
                    <label class="form-check-label">Salida</label>
                </div>
            </div>

            <div class="form-group mt-3">
                {{--<input type="submit" class="btn btn-block btn-success" value="Guardar">--}}
                <button type="submit" class="btn btn-block @if($tipos_id) btn-primary @else btn-success @endif "
                @if(!comprobarPermisos() || ($tipos_id && !comprobarPermisos())) disabled @endif >
                    <i class="fas fa-save"></i> Guardar @if($tipos_id) Cambios @endif
                </button>
            </div>

        </form>




    </div>

</div>
