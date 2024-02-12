<div class="row justify-content-center">

    <div class="col-md-4">
        @include('dashboard.parametros.card_form')
    </div>

    <div class="col-md-8">
        @include('dashboard.parametros.card_table')
    </div>

</div>
<div class="row justify-content-center">
    <div class="col-md-12">
        <label for="">Parametros Manuales</label>
        <ul>
            <li>numRowsPaginate[null|numero]</li>
            <li>size_codigo[tamaño|null]</li>
            {{--<li>formato_codigo_servicios[organizaciones_id|formato]</li>--}}
            {{--<li>proximo_codigo_ajutes[empresa_id|int]</li>--}}
            {{--<li>iva</li>
            <li>telefono_soporte</li>
            <li>codigo_pedido</li>--}}
        </ul>
    </div>
</div>
