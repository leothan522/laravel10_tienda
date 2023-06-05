<div class="row col-12 mb-2">
    <div class="col-md-2">
        <label>Código:</label>
    </div>
    <div class="col-md-5 mb-2">
        <span class="border badge-pill">{{ $articulo_codigo }}</span>
    </div>
    <div class="col-md-2 text-md-right">
        <label>Fecha:</label>
    </div>
    <div class="col-md-3">
        <span class="border badge-pill">{{ verFecha($articulo_fecha) }}</span>
    </div>
</div>

<div class="row col-12 mb-2">
    <div class="col-md-2">
        <label>Descripción:</label>
    </div>
    <div class="col-md-10">
        <span class="border badge-pill">{{ $articulo_descripcion }}</span>
    </div>
</div>

<div class="col-12">
    <div class="card card-navy card-outline card-tabs">
        <div class="card-header p-0 pt-1 border-bottom-0">
            <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#tabs_datos_basicos" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">Imagen</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="custom-tabs-three-tabContent">
                <div class="tab-pane fade active show" id="tabs_datos_basicos" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">

                    <form wire:submit.prevent="saveImagen" xmlns:wire="http://www.w3.org/1999/xhtml">

                        <div class="row justify-content-between p-2">

                            <div class="row col-md-6 attachment-block p-3">


                                <div class="col-12">
                                    <label class="col-md-12" for="name">
                                        Principal
                                        <span class="badge float-right"><i class="fas fa-image"></i></span>
                                    </label>

                                </div>

                                <div class="row col-12 justify-content-center mb-3 mt-3">
                                    <div class="col-8">
                                        <img class="img-thumbnail" style="cursor: pointer;"
                                             @if ($principalPhoto)
                                                src="{{ $principalPhoto->temporaryUrl() }}"
                                             @else
                                                src="{{ asset(verImagen($img_ver)) }}"
                                             @endif
                                             {{--width="101" height="100"--}}  alt="Imagen Pincipal Articulo" onclick="imgPrincipal()"/>
                                        @if($img_ver)
                                            <button type="button" class="btn badge text-danger position-absolute float-right"
                                                wire:click="btnBorrarImagen">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>


                                <div class="col-12 text-center">
                                    <div class="input-group d-none">
                                        <div class="custom-file">
                                            <input type="file" wire:model="principalPhoto" class="custom-file-input" id="customFileLang"
                                                   lang="es" accept="image/jpeg, image/png"
                                                {{--@if(!comprobarPermisos('categorias.create') || ($categoria_id && !comprobarPermisos('categorias.edit')))
                                                disabled @endif--}} >
                                            <label class="custom-file-label text-sm" for="customFileLang" data-browse="Elegir">
                                                <small>Seleccionar Imagen</small>
                                            </label>
                                        </div>
                                        <input type="text" wire:model="img_borrar_principal">
                                    </div>
                                    @error('principalPhoto')
                                    <span class="text-sm text-bold text-danger text-center">
                                        <i class="icon fas fa-exclamation-triangle"></i>
                                         {{ $message }}
                                    </span>
                                    @enderror
                                </div>



                            </div>

                            <div class="row col-md-6 attachment-block p-3">


                                <div class="col-12 mb-3">
                                    <label class="col-md-12">
                                        Galeria
                                        <span class="badge float-right"><i class="fas fa-images"></i></span>
                                    </label>
                                </div>
                                @php($i = 1)
                                @foreach($listarGaleria as $imagen)
                                    @if($i == 1) @php($photo = $photo1) @php($ver = $ver_galeria1) @endif
                                    @if($i == 2) @php($photo = $photo2) @php($ver = $ver_galeria2) @endif
                                    @if($i == 3) @php($photo = $photo3) @php($ver = $ver_galeria3) @endif
                                    @if($i == 4) @php($photo = $photo4) @php($ver = $ver_galeria4)  @endif
                                    @if($i == 5) @php($photo = $photo5) @php($ver = $ver_galeria5) @endif
                                    @if($i == 6) @php($photo = $photo6) @php($ver = $ver_galeria6) @endif
                                    <div class="col-4 mb-3">
                                        <div class="text-center">
                                            <img class="img-thumbnail"
                                                 @if ($photo) src="{{ $photo->temporaryUrl() }}" @else src="{{ asset(verImagen($ver)) }}" @endif
                                                 {{--width="101" height="100"--}}  alt="Imagen Categoria" onclick="imgGaleria({{ $i }})"/>
                                            <input type="file" wire:model="photo{{ $i }}"  id="img_Galeria_{{ $i }}"
                                                   lang="es" accept="image/jpeg, image/png" class="d-none"
                                                {{--@if(!comprobarPermisos('categorias.create') || ($categoria_id && !comprobarPermisos('categorias.edit')))
                                                disabled @endif--}} >
                                            <input type="hidden" wire:model="galeria_id{{ $i }}">
                                            <input type="hidden" wire:model="borrar_galeria{{ $i }}">
                                            @if($ver)
                                                <button type="button" class="btn badge text-danger"
                                                        wire:click="btnBorrarGaleria({{ $i }})">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                    @php($i++)
                                @endforeach
                                @for ($i; $i <= 6; $i++)
                                    @if($i == 1) @php($photo = $photo1) @endif
                                    @if($i == 2) @php($photo = $photo2) @endif
                                    @if($i == 3) @php($photo = $photo3) @endif
                                    @if($i == 4) @php($photo = $photo4) @endif
                                    @if($i == 5) @php($photo = $photo5) @endif
                                    @if($i == 6) @php($photo = $photo6) @endif
                                    <div class="col-4 mb-3">
                                        <div class="text-center">
                                            <img class="img-thumbnail"
                                                 @if ($photo) src="{{ $photo->temporaryUrl() }}" @else src="{{ asset(verImagen(null)) }}" @endif
                                                 {{--width="101" height="100"--}}  alt="Imagen Categoria" onclick="imgGaleria({{ $i }})"/>
                                            <input type="file" wire:model="photo{{ $i }}"  id="img_Galeria_{{ $i }}"
                                                   lang="es" accept="image/jpeg, image/png" class="d-none"
                                                {{--@if(!comprobarPermisos('categorias.create') || ($categoria_id && !comprobarPermisos('categorias.edit')))
                                                disabled @endif--}} >
                                            <input type="hidden" wire:model="galeria_id{{ $i }}">
                                            <input type="hidden" wire:model="borrar_galeria{{ $i }}">
                                        </div>
                                    </div>
                                @endfor


                                <div class="col-12 text-center">
                                    @error('photo1')
                                    <span class="text-sm text-bold text-danger text-center">
                                        <i class="icon fas fa-exclamation-triangle"></i>
                                         {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-12 text-center">
                                    @error('photo2')
                                    <span class="text-sm text-bold text-danger text-center">
                                        <i class="icon fas fa-exclamation-triangle"></i>
                                         {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-12 text-center">
                                    @error('photo3')
                                    <span class="text-sm text-bold text-danger text-center">
                                        <i class="icon fas fa-exclamation-triangle"></i>
                                         {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-12 text-center">
                                    @error('photo4')
                                    <span class="text-sm text-bold text-danger text-center">
                                        <i class="icon fas fa-exclamation-triangle"></i>
                                         {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-12 text-center">
                                    @error('photo5')
                                    <span class="text-sm text-bold text-danger text-center">
                                        <i class="icon fas fa-exclamation-triangle"></i>
                                         {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-12 text-center">
                                    @error('photo6')
                                    <span class="text-sm text-bold text-danger text-center">
                                        <i class="icon fas fa-exclamation-triangle"></i>
                                         {{ $message }}
                                    </span>
                                    @enderror
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
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
