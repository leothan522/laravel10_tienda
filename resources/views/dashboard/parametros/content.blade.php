<div class="row justify-content-center" xmlns:wire="http://www.w3.org/1999/xhtml">

    <div class="col-md-3">

        <div class="card card-gray-dark" style="height: inherit; width: inherit; transition: all 0.15s ease 0s;">

            <div class="card-header">
                <h3 class="card-title">Crear Parametro</h3>
                <div class="card-tools">
                    {{--<button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                    </button>--}}
                    <span class="btn btn-tool"><i class="fas fa-list"></i></span>
                </div>
            </div>

            <div class="card-body">
                @include('dashboard.parametros.form')
            </div>

            <div class="overlay-wrapper" wire:loading>
                <div class="overlay">
                    <i class="fas fa-2x fa-sync-alt"></i>
                </div>
            </div>

        </div>

        <label for="">Parametros Manuales</label>
        <ul>
            <li>iva</li>
            <li>telefono_soporte</li>
            <li>codigo_pedido</li>
        </ul>

    </div>

    <div class="col-md-9">
        <div class="card card-outline card-purple" style="height: inherit; width: inherit; transition: all 0.15s ease 0s;">
            <div class="card-header">
                <h3 class="card-title">
                    {{--@if($busqueda)
                        Resultados de la Busqueda { <b class="text-danger">{{ $busqueda }} </b>}
                    @else
                        Parametros Registrados
                    @endif--}}
                    Parametros Registrados
                </h3>
                <div class="card-tools">
                    {{--@if($busqueda)

                        <a href="{{ route('parametros.index') }}"
                           class="btn btn-tool btn-outline-primary text-danger" --}}{{--target="_blank"--}}{{-->
                            <i class="fas fa-list"></i> Ver Todos
                        </a>
                    @endif--}}
                    <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                </div>
            </div>
            <div class="card-body">
                @include('dashboard.parametros.table')
            </div>
        </div>
    </div>



</div>
