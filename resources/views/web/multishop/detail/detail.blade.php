<!-- Shop Detail Start -->
<div class="container-fluid pb-5">
    <div class="row px-xl-5">
        {{-- imagenes --}}
        <div class="col-lg-5 mb-30">
            <div id="product-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner bg-light">
                    <div class="carousel-item active">
                        @if($stock->porcentaje > 0)
                            <div class="porcentaje-descuento">-{{ $stock->porcentaje }}%</div>
                        @endif
                        <img class="w-100 h-100" src="{{ asset(verImagen($stock->imagen)) }}" alt="{{ $stock->nombre }}">
                    </div>
                    @foreach($stock->galeria as $imagen)
                        <div class="carousel-item">
                            @if($stock->porcentaje > 0)
                                <div class="porcentaje-descuento">-{{ $stock->porcentaje }}%</div>
                            @endif
                            <img class="w-100 h-100" src="{{ asset(verImagen($imagen->mini)) }}"
                                 alt="{{ $stock->nombre }}">
                        </div>
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                    <i class="fa fa-2x fa-angle-left text-dark"></i>
                </a>
                <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                    <i class="fa fa-2x fa-angle-right text-dark"></i>
                </a>
            </div>
        </div>

        {{--Descripcion--}}
        <div class="col-lg-7 h-auto mb-30">
            <div class="h-100 bg-light p-30">
                <h3>{{ $stock->nombre }}</h3>
                <div class="d-flex">
                    @if($stock->disponible > 0)
                        <small>Disponibles ({{ round($stock->disponible, 3) }} {{ $stock->unidad }})</small>
                    @else
                        <small class="text-danger">AGOTADO ({{ $stock->unidad }})</small>
                    @endif
                </div>
                <div class="d-flex mb-3">
                    <small class="pt-1">Codigo: {{ $stock->codigo }}</small>
                </div>
                <div class="d-flex mb-4">
                    @if($stock->moneda == "Dolares")
                        @if($stock->porcentaje > 0)
                            <h3 class=" font-weight-semi-bold">${{ formatoMillares($stock->oferta_dolares, 2) }}</h3>
                            <h4 class=" text-muted ml-2">
                                <del>${{ formatoMillares($stock->neto_dolares, 2) }}</del>
                            </h4>
                        @else
                            <h3 class=" font-weight-semi-bold">${{ formatoMillares($stock->neto_dolares, 2) }}</h3>
                        @endif
                    @else
                        @if($stock->porcentaje > 0)
                            <h3 class=" font-weight-semi-bold">{{ formatoMillares($stock->oferta_bolivares, 2) }}Bs.</h3>
                            <h4 class=" text-muted ml-2">
                                <del>{{ formatoMillares($stock->neto_bolivares, 2) }}Bs.</del>
                            </h4>
                        @else
                            <h3 class=" font-weight-semi-bold">{{ formatoMillares($stock->neto_bolivares, 2) }}Bs.</h3>
                        @endif
                    @endif
                </div>
                <p class="mb-4">{{ $stock->adicional }}</p>
                <div class="d-flex align-items-center mb-4 pt-2">
                    <div class="input-group quantity mr-3" style="width: 130px;">
                        <div class="input-group-btn">
                            <button class="btn btn-primary btn-minus">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <input type="text" class="form-control bg-secondary border-0 text-center" value="1">
                        <div class="input-group-btn">
                            <button class="btn btn-primary btn-plus">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    @auth
                        <button class="btn btn-primary px-3" onclick="verCargando()">
                            <i class="fa fa-shopping-cart mr-1"></i> Añadir
                        </button>
                    @else
                        <button class="btn btn-primary px-3" data-toggle="modal" data-target="#modal_login">
                            <i class="fa fa-shopping-cart mr-1"></i> Añadir
                        </button>
                    @endauth
                </div>
                <div class="d-flex pt-2 pb-4">
                    {{--<strong class="text-dark mr-2">Share on:</strong>--}}
                    <div class="d-inline-flex">
                        @auth
                            <button class="btn btn-outline-dark px-2" onclick="verCargando()">
                                <i class="far fa-heart mr-1"></i> Favoritos
                            </button>
                        @else
                            <button class="btn btn-outline-dark px-2" data-toggle="modal" data-target="#modal_login">
                                {{--<i class="far fa-heart mr-1"></i> Favoritos--}}
                                <i class="fas fa-heart mr-1 text-primary"></i> Favoritos
                            </button>
                        @endauth
                    </div>
                </div>
                @if($stock->marca)
                    <div class="d-flex pb-1">
                        <strong class="text-dark mr-2">Marca:</strong>
                        <div class="d-inline-flex">
                            {{ $stock->marca }}
                        </div>
                    </div>
                @endif
                @if($stock->modelo)
                    <div class="d-flex pb-1">
                        <strong class="text-dark mr-2">Modelo:</strong>
                        <div class="d-inline-flex">
                            {{ $stock->modelo }}
                        </div>
                    </div>
                @endif
                @if($stock->referencia)
                    <div class="d-flex pb-1">
                        <strong class="text-dark mr-2">Referencia:</strong>
                        <div class="d-inline-flex">
                            {{ $stock->referencia }}
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>

</div>
<!-- Shop Detail End -->
