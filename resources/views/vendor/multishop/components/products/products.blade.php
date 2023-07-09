<!-- Products Start -->
@if(!empty($products_lista))
    <div class="container-fluid pt-5 pb-3">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span
                class="bg-secondary pr-3">{{ $products_title }}</span></h2>
        <div class="row px-xl-5">
            @foreach($products_lista as $stock)
                @if(!$stock->mostrar)
                    @continue
                @endif
                <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                    <div class="product-item bg-light mb-4">
                        <div class="product-img position-relative overflow-hidden">
                            @if($stock->porcentaje > 0)
                                <div class="porcentaje-descuento">-{{ $stock->porcentaje }}%</div>
                            @endif
                            <img class="img-fluid w-100" src="{{ verImagen($stock->imagen) }}" alt="">
                            <div class="product-action">
                                @if($stock->porcentaje > 0)
                                    <div class="porcentaje-descuento">-{{ $stock->porcentaje }}%</div>
                                @endif
                                @auth
                                    <a class="btn btn-outline-dark btn-square" onclick="verCargando()"><i
                                            class="fa fa-shopping-cart"></i></a>
                                    <a class="btn btn-outline-dark btn-square" onclick="verCargando()"><i
                                            class="far fa-heart"></i></a>
                                @else
                                    <a class="btn btn-outline-dark btn-square" data-toggle="modal"
                                       data-target="#modal_login">
                                        <i class="fa fa-shopping-cart"></i>
                                    </a>
                                    <a class="btn btn-outline-dark btn-square" data-toggle="modal"
                                       data-target="#modal_login">
                                        <i class="far fa-heart"></i>
                                    </a>
                                @endauth
                                {{--<a class="btn btn-outline-dark btn-square"><i class="fa fa-sync-alt"></i></a>--}}
                                <a class="btn btn-outline-dark btn-square" href="{{ route('web.detail', $stock->id) }}" onclick="verCargando()">
                                    <i class="fa fa-search"></i>
                                </a>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate" href="{{ route('web.detail', $stock->id) }}" onclick="verCargando()">{{ $stock->nombre }}</a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                @if($stock->moneda == "Dolares")
                                    @if($stock->porcentaje > 0)
                                        <h5>${{ formatoMillares($stock->oferta_dolares, 2) }}</h5>
                                        <h6 class="text-muted ml-2">
                                            <del>${{ formatoMillares($stock->neto_dolares, 2) }}</del>
                                        </h6>
                                    @else
                                        <h5>${{ formatoMillares($stock->neto_dolares, 2) }}</h5>
                                    @endif
                                @else
                                    @if($stock->porcentaje > 0)
                                        <h5>{{ formatoMillares($stock->oferta_bolivares, 2) }}Bs.</h5>
                                        <h6 class="text-muted ml-2">
                                            <del>{{ formatoMillares($stock->neto_bolivares, 2) }}Bs.</del>
                                        </h6>
                                    @else
                                        <h5>{{ formatoMillares($stock->neto_bolivares, 2) }}Bs.</h5>
                                    @endif
                                @endif
                            </div>
                            <div class="d-flex align-items-center justify-content-center mb-1">
                                {{--<small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>--}}
                                @if($stock->disponible > 0)
                                    <small>Disponibles ({{ round($stock->disponible, 3) }} {{ $stock->unidad }})</small>
                                @else
                                    <small class="text-danger">AGOTADO ({{ $stock->unidad }})</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
<!-- Products End -->
