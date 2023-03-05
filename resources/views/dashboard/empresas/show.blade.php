<div class="row col-md-12">

    <div class="col-md-6">

        <div class="card card-outline card-navy">

            <div class="card-body box-profile">
                <h1 class="profile-username text-center text-bold">
                    {{ $nombre }}
                </h1>
                <ul class="list-group list-group-unbordered mt-3">
                    <li class="list-group-item">
                        <b>RIF</b> <a class="float-right">{{ $rif }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Jefe</b> <a
                            class="float-right">{{ $jefe }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Moneda Base</b> <a
                            class="float-right">{{ strtolower($moneda) }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Telefonos</b> <a
                            class="float-right">{{ $telefonos }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Email</b> <a
                            class="float-right">{{ strtolower($email) }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Dirección</b> <a
                            class="float-right">{{ strtoupper($direccion) }}</a>
                    </li>
                </ul>
            </div>

        </div>


    </div>

    <div class="col-md-6">

        <div class="card card-navy card-outline">
            <div class="card-body box-profile">
                <div class="row">
                    <div class="col-md-8">
                        @if(estatusTienda($empresa_id))
                            <div class="alert alert-success">
                                <h5><i class="icon fas fa-check"></i> ¡Abierto!</h5>
                                Hora actual: <strong>{{ date('h:i a') }}</strong>. Estatus: <strong> OPEN </strong>
                            </div>
                        @else
                            <div class="alert alert-danger">
                                <h5><i class="icon fas fa-ban"></i> ¡Cerrado!</h5>
                                Hora actual: <strong>{{ date('h:i a') }}</strong>. Estatus: <strong> CLOSED </strong>
                            </div>
                        @endif
                        @if($verDefault)
                            <ul class="list-group text-sm">
                                <li class="list-group-item bg-warning text-bold">
                                    Tienda Default
                                    <span class="float-right text-bold"><i class="fas fa-certificate text-muted text-xs"></i></span>
                                </li>
                            </ul>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <img class="img-thumbnail" src="{{ asset(verImagen($verImagen)) }}" {{--width="101" height="100"--}}  alt="Logo Tienda"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
