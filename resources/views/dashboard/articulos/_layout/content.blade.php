@if($empresas_id)
    <div class="row">
        <div class="col-md-5">
            @include('dashboard.articulos._layout.table')
        </div>
        <div class="col-md-7">
            @include('dashboard.articulos._layout.card_view')
        </div>
    </div>
@endif
