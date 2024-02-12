@if($listarCategorias->isNotEmpty())
    <div class="container-fluid @if(!isset($shop_id)) pt-5 @endif" xmlns:wire="http://www.w3.org/1999/xhtml">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Categorías</span></h2>
        <div class="row px-xl-5 pb-3">
            @foreach($listarCategorias as $categoria)
                <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                    <a class="text-decoration-none" @if($categoria->stock > 0) href="{{ route('web.categoria', $categoria->id) }}" @else wire:click="noCategoriaStock" @endif onclick="verCargando()">
                        <div class="cat-item d-flex align-items-center mb-4">
                            <div class="overflow-hidden" style="width: 100px; height: 100px;">
                                <img class="img-fluid" src="{{ verImagen($categoria->mini, false, true) }}" alt="">
                            </div>
                            <div class="flex-fill pl-3">
                                <h6>{{ $categoria->nombre }}</h6>
                                <small class="text-body">{{ formatoMillares($categoria->stock, 0) }} Productos</small>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endif
