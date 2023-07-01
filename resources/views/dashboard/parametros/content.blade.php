<div class="row justify-content-center">

    <div class="col-md-4">
        @include('dashboard.parametros.card_form')
        <label for="">Parametros Manuales</label>
        <ul>
            <li>numRowsPaginate[null|numero]</li>
            <li>size_codigo[tamaño|null]</li>
            <li>proximo_codigo_ajutes[empresa_id|int]</li>
            <li>formato_codigo_ajutes[empresa_id|formato]</li>
            <li>editable_codigo_ajutes[empresa_id|1/-0]</li>
            <li>editable_fecha_ajutes[empresa_id|1/-0]</li>
            <li>telefono_soporte[null|telefono]</li>
            {{--<li>codigo_pedido</li>--}}
        </ul>
    </div>

    <div class="col-md-8">
        @include('dashboard.parametros.card_table')
    </div>

</div>
