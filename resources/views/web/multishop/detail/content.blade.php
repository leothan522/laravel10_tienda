@include('web.multishop.detail.breadcrumb')
@include('web.multishop.detail.detail')
@include('vendor.multishop.components.products.products',[
    'products_title' => 'También te puede interesar',
    'products_lista' => $listarStock
    ])
@include('web.multishop.index.modal_login')
