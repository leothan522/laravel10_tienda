@include('web.multishop.shop.breadcrumb')
<!-- Shop Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        @include('vendor.multishop.components.shop.sidebar', [
            'listarFiltros' => $shop->filtros
            ])

        @if($verProductos)
            @include('vendor.multishop.components.shop.products', [
                'listarFiltros' => $shop->filtros,
                'products_lista' => $listarStock
                ])
        @endif

        @if($verCategoria)
            <div class="d-lg-none">
                @include('vendor.multishop.components.categories.categories')
            </div>
        @endif

    </div>
</div>
<!-- Shop End -->
@include('web.multishop.index.modal_login')
