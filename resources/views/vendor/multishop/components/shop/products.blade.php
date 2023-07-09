<!-- Shop Product Start -->
<div class="col-lg-9 col-md-8">
    <div class="row pb-3">

        <div class="col-12 pb-1">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div>
                    {{--<button class="btn btn-sm btn-light"><i class="fa fa-th-large"></i></button>
                    <button class="btn btn-sm btn-light ml-2"><i class="fa fa-bars"></i></button>--}}
                    <span class="section-title position-relative text-uppercase"><span class="bg-secondary pr-3">Productos</span></span>
                </div>
                <div class="ml-2">
                    @if(!empty($listarFiltros))
                        @foreach($listarFiltros as $filtro)
                            <div class="btn-group d-lg-none">
                                <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">
                                    {{ strtoupper('Filtrar por '.$filtro['label']) }}
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    @foreach($filtro['array'] as $filter)
                                        <a class="dropdown-item">{{ $filter['nombre'] }}</a>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        @if(!empty($products_lista))
            @foreach($products_lista as $stock)
                @if(!$stock->mostrar)
                    @continue
                @endif

                <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
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

            <div class="col-12">
                <nav>
                    <ul class="pagination justify-content-center">
                        {{--<li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>--}}
                        {{ $products_lista->links() }}
                    </ul>
                </nav>
            </div>

        @endif




    </div>
</div>
<!-- Shop Product End -->
