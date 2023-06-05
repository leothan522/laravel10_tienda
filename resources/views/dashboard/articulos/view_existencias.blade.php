<div class="row col-12 mb-2" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="col-md-2">
        <label>Código:</label>
    </div>
    <div class="col-md-5 mb-2">
        <span class="border badge-pill">{{ $articulo_codigo }}</span>
    </div>
    <div class="col-md-2 text-md-right">
        <label>Fecha:</label>
    </div>
    <div class="col-md-3">
        <span class="border badge-pill">{{ verFecha($articulo_fecha) }}</span>
    </div>
</div>

<div class="row col-12 mb-2">
    <div class="col-md-2">
        <label>Descripción:</label>
    </div>
    <div class="col-md-10">
        <span class="border badge-pill">{{ $articulo_descripcion }}</span>
    </div>
</div>

<div class="col-12">
    <div class="card card-navy card-outline card-tabs">
        <div class="card-header p-0 pt-1 border-bottom-0">
            <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#tabs_datos_basicos" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">Existencias</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="custom-tabs-three-tabContent">
                <div class="tab-pane fade active show" id="tabs_datos_basicos" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">


                    <div class="row table-responsive p-0">
                        <table class="table">
                        <thead>
                                <tr class="text-navy">
                                    <th style="width: 5%">#</th>
                                    <th>Tienda</th>
                                    <th style="width: 10%" class="text-right">Actual</th>
                                    <th style="width: 10%" class="text-right">Comprom.</th>
                                    <th style="width: 10%" class="text-right">Disponible</th>
                                </tr>
                                </thead>
                            <tbody>
                            @php($i = 0)
                            @foreach($listarStock as $stock)
                                @php($i++)
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $stock->empresa->nombre }}</td>
                                    <td class="text-right">{{ formatoMillares($stock->actual, 3) }}</td>
                                    <td class="text-right">{{ formatoMillares($stock->comprometido, 3) }}</td>
                                    <td class="text-right">{{ formatoMillares($stock->disponible, 3) }}</td>
                                </tr>
                            @endforeach
                            @if($listarStock->count() >=2)
                                <tr class="text-navy">
                                    <th>&nbsp;</th>
                                    <th>TOTALES</th>
                                    <th class="text-right">{{ formatoMillares($listarStock->sum('actual'), 3) }}</th>
                                    <th class="text-right">{{ formatoMillares($listarStock->sum('comprometido'), 3) }}</th>
                                    <th class="text-right">{{ formatoMillares($listarStock->sum('disponible'), 3) }}</th>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
