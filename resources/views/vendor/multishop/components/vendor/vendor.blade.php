@if($listarEmpresas->isNotEmpty())
    <div class="container-fluid py-5">
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel vendor-carousel">
                    @foreach($listarEmpresas as $empresa)
                        <div class="bg-light p-4">
                            <img src="{{ verImagen($empresa->mini, false, true) }}" alt="">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif
