<form {{--wire:submit.prevent="store"--}} xmlns:wire="http://www.w3.org/1999/xhtml">

    <div class="form-group">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text text-bold">nombre{{--<i class="fas fa-code"></i>--}}</span>
            </div>
            <input type="text" class="form-control" {{--wire:model.defer="nombre"--}} name="nombre" placeholder="[string]">
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
                <span class="input-group-text text-bold">tabla_id{{--<i class="fas fa-code"></i>--}}</span>
            </div>
            <input type="text" class="form-control" {{--wire:model.defer="tabla_id"--}} name="tabla_id" placeholder="[integer]">
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
                <span class="input-group-text text-bold">valor{{--<i class="fas fa-code"></i>--}}</span>
            </div>
            <input type="text" class="form-control" {{--wire:model.defer="valor"--}} name="valor" placeholder="[string]">
            @error('valor')
            <span class="col-sm-12 text-sm text-bold text-danger">
                <i class="icon fas fa-exclamation-triangle"></i>
                {{ $message }}
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group text-right">
        <input type="submit" class="btn btn-block btn-success" value="Guardar">
    </div>

</form>

