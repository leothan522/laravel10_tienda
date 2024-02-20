<div class="row @if($view == 'form') d-block @else d-none @endif"  xmlns:wire="http://www.w3.org/1999/xhtml">

    <form class="row col-md-12" wire:submit="save">

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
                            <input type="text" class="form-control" wire:model="codigo" placeholder="alfanumérico">
                            @error('codigo')
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
                            <input type="text" class="form-control" wire:model="descripcion" placeholder="Descripción corta del articulo">
                            @error('descripcion')
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
                            <div class="input-group mb-3" id="div_select_articulos_tipos">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-object-ungroup"></i>
                                    </span>
                                </div>
                                <select id="select_articulos_tipos"></select>
                            </div>
                        </div>
                        @error('tipos_id')
                        <span class="col-sm-12 text-sm text-bold text-danger">
                                    <i class="icon fas fa-exclamation-triangle"></i>
                                    {{ $message }}
                                </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Categoría:</label>
                        <div wire:ignore>
                            <div class="input-group mb-3" id="div_select_articulos_categorias">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-tags"></i></span>
                                </div>
                                <select id="select_articulos_categorias"></select>
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
                        <label for="email">Procedencia:</label>
                        <div wire:ignore>
                            <div class="input-group mb-3" id="div_select_articulos_procedencias">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-object-ungroup"></i></span>
                                </div>
                                <select id="select_articulos_procedencias"></select>
                            </div>
                        </div>
                        @error('procedencias_id')
                        <span class="col-sm-12 text-sm text-bold text-danger">
                                    <i class="icon fas fa-exclamation-triangle"></i>
                                    {{ $message }}
                                </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">I.V.A.:</label>
                        <div wire:ignore>
                            <div class="input-group mb-3" id="div_select_articulos_tributarios">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-coins"></i></span>
                                </div>
                                <select id="select_articulos_tributarios"></select>
                            </div>
                        </div>
                        @error('tributarios_id')
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
                            <input type="text" class="form-control" wire:model="marca" placeholder="Marca (Opcional)">
                            @error('marca')
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
                            <input type="text" class="form-control" wire:model="modelo" placeholder="Modelo (Opcional)">
                            @error('modelo')
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
                            <input type="text" class="form-control" wire:model="referencia" placeholder="Referencia (Opcional)">
                            @error('referencia')
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
                            <textarea class="form-control" wire:model="adicional" placeholder="Información Adicional (Opcional)"></textarea>
                            @error('adicional')
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
                <button type="submit" class="btn btn-block @if(!$new_articulo) btn-primary @else btn-success @endif ">
                    <i class="fas fa-save"></i> Guardar @if(!$new_articulo) cambios @endif
                </button>
            </div>
        </div>


    </form>
</div>
