@if(!empty($products_lista))
    <div class="container-fluid pt-5 pb-3">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span
                class="bg-secondary pr-3">{{ $products_title }}</span></h2>
        <div class="row px-xl-5">
            @foreach($products_lista as $stock)
                <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                    <div class="product-item bg-light mb-4">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100" src="{{ verImagen($stock->articulo->mini) }}" alt="">
                            <div class="product-action">
                                @auth
                                    <a class="btn btn-outline-dark btn-square" onclick="verCargando()"><i class="fa fa-shopping-cart"></i></a>
                                    <a class="btn btn-outline-dark btn-square" onclick="verCargando()"><i class="far fa-heart"></i></a>
                                @else
                                    <a class="btn btn-outline-dark btn-square" data-toggle="modal" data-target="#modal_login">
                                        <i class="fa fa-shopping-cart"></i>
                                    </a>
                                    <a class="btn btn-outline-dark btn-square" data-toggle="modal" data-target="#modal_login">
                                        <i class="far fa-heart"></i>
                                    </a>
                                @endauth
                                <a class="btn btn-outline-dark btn-square"><i class="fa fa-sync-alt"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-search"></i></a>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate" href="">{{ $stock->articulo->descripcion }}</a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5>$123.00</h5>
                                <h6 class="text-muted ml-2">
                                    <del>$123.00</del>
                                </h6>
                            </div>
                            <div class="d-flex align-items-center justify-content-center mb-1">
                                {{--<small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>--}}
                                <small>Disponibles ({{ round($stock->disponible, 3) }} {{ $stock->unidad->codigo }})</small>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
