<div class="card card-navy" style="height: inherit; width: inherit; transition: all 0.15s ease 0s;"
     xmlns:wire="http://www.w3.org/1999/xhtml">

    <div class="card-header">
        <h3 class="card-title">Crear Oferta</h3>
        <div class="card-tools">
            {{--<button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
            </button>--}}
            {{--<span class="btn btn-tool"><i class="fas fa-list"></i></span>--}}
            {{--<span class="btn btn-tool"><i class="fas fa-ban"></i> Cancelar</span>--}}
            @if($oferta_id)
                <button class="btn btn-tool" wire:click="limpiar"><i class="fas fa-ban"></i> Cancelar</button>
            @else
                <span class="btn btn-tool" wire:click="limpiar"><i class="fas fa-file"></i></span>
            @endif
        </div>
    </div>

    <div class="card-body">


        <form wire:submit="save" xmlns:wire="http://www.w3.org/1999/xhtml">


            <div class="form-group">
                <label for="email">Afectados:</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-gift"></i></span>
                    </div>
                    <select class="form-control" wire:model="afectados">
                        <option value="">Seleccione</option>
                        <option value="0">Todos</option>
                        <option value="1">Categoria</option>
                        <option value="2">Articulo</option>
                    </select>
                </div>
                @error('afectados')
                <span class="col-sm-12 text-sm text-bold text-danger">
                    <i class="icon fas fa-exclamation-triangle"></i>
                    {{ $message }}
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Categoría:</label>
                <div wire:ignore>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-tags"></i></span>
                        </div>
                        <select id="select_categorias">
                            <option value=""></option>
                            @foreach($listarCategorias as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->codigo }} {{ $categoria->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @error('categorias_id')
                <span class="col-sm-12 text-sm text-bold text-danger">
                    <i class="icon fas fa-exclamation-triangle"></i>
                    {{ $message }}
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Articulo:</label>
                <div wire:ignore>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-box"></i></span>
                        </div>
                        <select id="select_articulos">
                            <option value=""></option>
                            @foreach($listarArticulos as $articulo)
                                <option value="{{ $articulo->id }}">{{ $articulo->codigo }} {{ $articulo->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @error('articulos_id')
                <span class="col-sm-12 text-sm text-bold text-danger">
                    <i class="icon fas fa-exclamation-triangle"></i>
                    {{ $message }}
                </span>
                @enderror
            </div>

            <div class="form-group">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text text-bold">Desde{{--<i class="fas fa-code"></i>--}}</span>
                    </div>
                    <input type="datetime-local" class="form-control" wire:model="desde">
                    @error('desde')
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
                        <span class="input-group-text text-bold">Hasta{{--<i class="fas fa-code"></i>--}}</span>
                    </div>
                    <input type="datetime-local" class="form-control" wire:model="hasta">
                    @error('hasta')
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
                        <span class="input-group-text text-bold">Descuento %{{--<i class="fas fa-code"></i>--}}</span>
                    </div>
                    <input type="number" class="form-control" wire:model="descuento" placeholder="[numero]" min="1" max="100">
                    @error('descuento')
                    <span class="col-sm-12 text-sm text-bold text-danger">
                        <i class="icon fas fa-exclamation-triangle"></i>
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group text-right">
                {{--<input type="submit" class="btn btn-block btn-success" value="Guardar">--}}
                <button type="submit" class="btn btn-block btn-success">
                    <i class="fas fa-save"></i> Guardar @if($oferta_id) Cambios @endif
                </button>
            </div>

        </form>




    </div>

    {!! verSpinner() !!}

</div>
