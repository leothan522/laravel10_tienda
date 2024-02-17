<div class="invoice p-0 mb-3 @if(!$empresas_id) d-none @endif " xmlns:wire="http://www.w3.org/1999/xhtml">
    @include('dashboard.stock._layout.table')
    @include('dashboard.stock._layout.modal')
    {!! verSpinner() !!}
</div>

<div class="row">
    <div class="col-12" style="height: 60vh">
        <div class="overlay-wrapper d-none cargar_stock">
            <div class="overlay">
                <div class="spinner-border text-navy" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</div>
