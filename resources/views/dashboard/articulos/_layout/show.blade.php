<div class="row @if($view == 'show') d-block @else d-none @endif">

    <div class="row col-12 mb-2">
        <div class="col-md-2">
            <label>Código:</label>
        </div>
        <div class="col-md-5 mb-2">
            <span class="border badge-pill">{{ $codigo }}</span>
        </div>
        <div class="col-md-2 text-md-right">
            <label>Fecha:</label>
        </div>
        <div class="col-md-3">
            <span class="border badge-pill">{{ verFecha($fecha) }}</span>
        </div>
    </div>

    <div class="row col-12 mb-2">
        <div class="col-md-2">
            <label>Descripción:</label>
        </div>
        <div class="col-md-10">
            <span class="border badge-pill">{{ $descripcion }}</span>
        </div>
    </div>

    <div class="col-12 @if(!$imagen && !$existencias) d-block @else d-none @endif ">
        <div class="card card-navy card-outline card-tabs">
            <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill"
                           href="#tabs_datos_basicos" role="tab" aria-controls="custom-tabs-three-home"
                           aria-selected="true">Datos Básicos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill"
                           href="#tabs_datos_adicionales" role="tab" aria-controls="custom-tabs-three-profile"
                           aria-selected="false">Datos Adicionales</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-three-tabContent">
                    <div class="tab-pane fade active show" id="tabs_datos_basicos" role="tabpanel"
                         aria-labelledby="custom-tabs-three-home-tab">


                        <div class="row table-responsive p-0">
                            <table class="table table-sm">
                                <tbody>
                                <tr>
                                    <th scope="row" style="width: 10%">Tipo:</th>
                                    <td colspan="2">
                                        <span class="">{{ $tipo }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" style="width: 10%">Categoría:</th>
                                    <td style="width: 10%;">{{ $categorias_code }}</td>
                                    <td>
                                        <span class="">{{ $categoria }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Procedencia:</th>
                                    <td>
                                        <span class="">{{ $procedencias_code }}</span>
                                    </td>
                                    <td>
                                        <span class="">{{ $procedencia }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">I.V.A.:</th>
                                    <td colspan="2">
                                        <span class="">{{ $tributario }}</span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="tabs_datos_adicionales" role="tabpanel"
                         aria-labelledby="custom-tabs-three-profile-tab">


                        <div class="row table-responsive p-0">
                            <table class="table table-sm">
                                <tbody>
                                <tr>
                                    <th scope="row" style="width: 30%">Marca:</th>
                                    <td colspan="2">
                                        <span class="">{{ $marca }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Modelo:</th>
                                    <td colspan="2">
                                        <span class="">{{ $modelo }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Referencia:</th>
                                    <td colspan="2">
                                        <span class="">{{ $referencia }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">Información Adicional:</th>
                                    <td colspan="2">
                                        <span class="">{{ $adicional }}</span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>

</div>
