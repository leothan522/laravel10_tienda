<!-- Breadcrumb Start -->
<div class="container-fluid">
    <div class="row px-xl-5">
        <div class="col-12">
            <nav class="breadcrumb bg-light mb-30" id="breadcrumb">
                <a class="breadcrumb-item text-dark d-none d-lg-inline-flex" href="{{ route('web.index') }}">Inicio</a>
                <a class="breadcrumb-item text-dark d-none d-lg-inline-flex" href="#">{{ $stock->categoria }}</a>
                <a class="breadcrumb-item text-dark" href="#">{{ $stock->empresa->nombre }}</a>
                <span class="breadcrumb-item active">Ver Detalles</span>
            </nav>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->
