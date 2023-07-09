@if($listarOfertas)
    <div class="container-fluid pt-5 pb-3">
    <div class="row px-xl-5 justify-content-center">
        @foreach($listarOfertas as $oferta)
            @if(!$oferta->mostrar) @continue @endif
            <div class="col-md-6">
            <div class="product-offer mb-30" style="height: 300px;">
                <img class="img-fluid" src="{{ verImagen($oferta->imagen) }}" alt="">
                <div class="offer-text">
                    <h6 class="text-white text-uppercase">Ahorre {{ $oferta->descuento }}%</h6>
                    <h3 class="text-white mb-3">{{ $oferta->titulo }}</h3>
                    <a href="{{ $oferta->url }}" class="btn btn-primary">{{ $oferta->boton }}</a>
                </div>
            </div>
        </div>
        @endforeach
        {{--<div class="col-md-6">
            <div class="product-offer mb-30" style="height: 300px;">
                <img class="img-fluid" src="{{ asset('vendor/multishop/img/offer-2.jpg') }}" alt="">
                <div class="offer-text">
                    <h6 class="text-white text-uppercase">Ahorre 20%</h6>
                    <h3 class="text-white mb-3">Oferta Especial</h3>
                    <a href="" class="btn btn-primary">Compra ahora</a>
                </div>
            </div>
        </div>--}}
    </div>
</div>
@endif
