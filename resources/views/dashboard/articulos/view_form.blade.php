<div class="row" xmlns:wire="http://www.w3.org/1999/xhtml">

    <form class="row col-md-12" wire:submit.prevent="saveArticulos">

        <div class="col-md-6">

            <div class="card card-outline card-navy">

                <div class="card-header">
                    <h5 class="card-title">Datos Básicos</h5>
                    <div class="card-tools">
                        <span class="btn-tool"><i class="fas fa-book"></i></span>
                    </div>
                </div>

                <div class="card-body">


                    <div class="form-group">
                        <label for="name">Código:</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-code"></i></span>
                            </div>
                            <input type="text" class="form-control" wire:model.defer="articulo_codigo" placeholder="alfanumérico">
                            @error('articulo_codigo')
                            <span class="col-sm-12 text-sm text-bold text-danger">
                                <i class="icon fas fa-exclamation-triangle"></i>
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">Descripción:</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-box"></i></span>
                            </div>
                            <input type="text" class="form-control" wire:model.defer="articulo_descripcion" placeholder="Descripción corta del articulo">
                            @error('articulo_descripcion')
                            <span class="col-sm-12 text-sm text-bold text-danger">
                                <i class="icon fas fa-exclamation-triangle"></i>
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">Tipo:</label>
                        <div wire:ignore>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-object-ungroup"></i></span>
                                </div>
                                <select id="select_articulos_tipos"></select>
                            </div>
                        </div>
                        @error('articulo_tipos_id')
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
                                <select id="select_articulos_categorias"></select>
                            </div>
                        </div>
                        @error('articulo_categorias_id')
                        <span class="col-sm-12 text-sm text-bold text-danger">
                                    <i class="icon fas fa-exclamation-triangle"></i>
                                    {{ $message }}
                                </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Procedencia:</label>
                        <div wire:ignore>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-object-ungroup"></i></span>
                                </div>
                                <select id="select_articulos_procedencias"></select>
                            </div>
                        </div>
                        @error('articulo_procedencias_id')
                        <span class="col-sm-12 text-sm text-bold text-danger">
                                    <i class="icon fas fa-exclamation-triangle"></i>
                                    {{ $message }}
                                </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">I.V.A.:</label>
                        <div wire:ignore>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-coins"></i></span>
                                </div>
                                <select id="select_articulos_tributarios"></select>
                            </div>
                        </div>
                        @error('articulo_tributarios_id')
                        <span class="col-sm-12 text-sm text-bold text-danger">
                                    <i class="icon fas fa-exclamation-triangle"></i>
                                    {{ $message }}
                                </span>
                        @enderror
                    </div>



                </div>

            </div>

        </div>

        <div class="col-md-6">

            <div class="card card-outline card-navy">
                <div class="card-header">
                    <h5 class="card-title">Datos Adicionales</h5>
                    <div class="card-tools">
                        <span class="btn-tool"><i class="fas fa-book"></i></span>
                    </div>
                </div>
                <div class="card-body">

                    <div class="form-group">
                        <label for="email">Marca:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fab fa-medium-m"></i></span>
                            </div>
                            <input type="text" class="form-control" wire:model.defer="articulo_marca" placeholder="Marca (Opcional)">
                            @error('articulo_marca')
                            <span class="col-sm-12 text-sm text-bold text-danger">
                                <i class="icon fas fa-exclamation-triangle"></i>
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">Modelo:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="far fa-bookmark"></i></span>
                            </div>
                            <input type="text" class="form-control" wire:model.defer="articulo_modelo" placeholder="Modelo (Opcional)">
                            @error('articulo_modelo')
                            <span class="col-sm-12 text-sm text-bold text-danger">
                                <i class="icon fas fa-exclamation-triangle"></i>
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">Referencia:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="far fa-bookmark"></i></span>
                            </div>
                            <input type="text" class="form-control" wire:model.defer="articulo_referencia" placeholder="Referencia (Opcional)">
                            @error('articulo_referencia')
                            <span class="col-sm-12 text-sm text-bold text-danger">
                            <i class="icon fas fa-exclamation-triangle"></i>
                            {{ $message }}
                        </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name">Información Adicional:</label>
                        <div class="input-group">
                            <textarea class="form-control" wire:model.defer="articulo_adicional" placeholder="Información Adicional (Opcional)"></textarea>
                            @error('articulo_adicional')
                            <span class="col-sm-12 text-sm text-bold text-danger">
                                <i class="icon fas fa-exclamation-triangle"></i>
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <div class="col-md-12">
            <div class="col-md-4 float-right">
                <button type="submit" class="btn btn-block btn-success">
                    <i class="fas fa-save"></i> Guardar
                </button>
            </div>
        </div>


    </form>
</div>
