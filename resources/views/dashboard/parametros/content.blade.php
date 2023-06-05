<div class="row justify-content-center">

    <div class="col-md-3">
        @include('dashboard.parametros.card_form')
        <label for="">Parametros Manuales</label>
        <ul>
            <li>numRowsPaginate</li>
            {{--<li>iva</li>
            <li>telefono_soporte</li>
            <li>codigo_pedido</li>--}}
        </ul>
    </div>

    <div class="col-md-9">
        @include('dashboard.parametros.card_table')
    </div>

</div>
