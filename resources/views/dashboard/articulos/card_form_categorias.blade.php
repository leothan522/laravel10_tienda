<div class="card card-navy" style="height: inherit; width: inherit; transition: all 0.15s ease 0s;"
     xmlns:wire="http://www.w3.org/1999/xhtml">

    <div class="card-header">
        @if($categoria_id)
            <h3 class="card-title">Editar Categoria</h3>
            <div class="card-tools">
                <button class="btn btn-tool" wire:click="limpiarCategorias">
                    <i class="fas fa-ban"></i> Cancelar
                </button>
            </div>
            @else
            <h3 class="card-title">Crear Categoria</h3>
            <div class="card-tools">
                <span class="btn btn-tool"><i class="fas fa-file"></i></span>
            </div>
        @endif
    </div>

    <div class="card-body">


        <form wire:submit="saveCategoria">

            <div class="form-group">
                <label for="name">Codigo</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-code"></i></span>
                    </div>
                    <input type="text" class="form-control" wire:model="categoria_codigo" placeholder="Codigo Categoria">
                    @error('categoria_codigo')
                    <span class="col-sm-12 text-sm text-bold text-danger">
                        <i class="icon fas fa-exclamation-triangle"></i>
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="name">{{ __('Name') }}</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-tag"></i></span>
                    </div>
                    <input type="text" class="form-control" wire:model="categoria_nombre" placeholder="Nombre Categoria">
                    @error('categoria_nombre')
                    <span class="col-sm-12 text-sm text-bold text-danger">
                        <i class="icon fas fa-exclamation-triangle"></i>
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>

            <div class="row justify-content-center attachment-block p-3">

                <div class="col-md-12">
                    <label class="col-md-12" for="name">
                        Imagen
                        <span class="badge float-right"><i class="fas fa-image"></i></span>
                    </label>

                </div>

                <div class="col-md-10 mb-3 mt-3">
                    <div class="text-center" style="cursor: pointer;">
                        <img class="img-thumbnail"
                             @if ($categoriaPhoto) src="{{ $categoriaPhoto->temporaryUrl() }}" @else src="{{ asset(verImagen($verMini)) }}" @endif
                             {{--width="101" height="100"--}}  alt="Imagen Categoria" onclick="imgCategoria()"/>
                        @if($verMini)
                            <button type="button" class="btn badge text-danger position-absolute float-right"
                                    wire:click="btnBorrarImgCategoria">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        @endif
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="input-group d-none">
                        <div class="custom-file">
                            <input type="file" wire:model.live="categoriaPhoto" class="custom-file-input" id="customFileLangCategoria"
                                   lang="es" accept="image/jpeg, image/png"
                                   @if(!comprobarPermisos('categorias.create') || ($categoria_id && !comprobarPermisos('categorias.edit')))
                                   disabled @endif >
                            <label class="custom-file-label text-sm" for="customFileLangCategoria" data-browse="Elegir">
                                Seleccionar Imagen
                            </label>
                        </div>
                        <input type="text" wire:model.live="img_borrar_categoria">
                    </div>
                    @error('categoriaPhoto')
                    <span class="text-sm text-bold text-danger text-center">
                        <i class="icon fas fa-exclamation-triangle"></i>
                         {{ $message }}
                    </span>
                    @enderror
                </div>

            </div>

            <div class="form-group mt-3">
                {{--<input type="submit" class="btn btn-block btn-success" value="Guardar">--}}
                <button type="submit" class="btn btn-block btn-success"
                @if(!comprobarPermisos('categorias.create') || ($categoria_id && !comprobarPermisos('categorias.edit')))
                disabled @endif >
                    <i class="fas fa-save"></i> Guardar @if($categoria_id) Cambios @endif
                </button>
            </div>

        </form>




    </div>

    {{--{!! verSpinner() !!}--}}

</div>
