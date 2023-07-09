<!-- Breadcrumb Start -->
<div class="container-fluid" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="row px-xl-5">
        <div class="col-12">
            <nav class="breadcrumb bg-light mb-30" id="breadcrumb">
                <a class="breadcrumb-item text-dark d-none d-lg-inline-flex" href="{{ route('web.index') }}">Inicio</a>
                @if($view == 'categoria')
                    <a class="breadcrumb-item text-dark d-none d-lg-inline-flex" href="{{ route('web.categoria', $shop_id) }}">Ver Categoría</a>
                    <a class="breadcrumb-item text-dark d-lg-none" wire:click="btnVerCategoria" onclick="verCargando()">Categorías</a>
                @endif
                <span class="breadcrumb-item active">{{ $shop->nombre }}</span>
            </nav>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->
