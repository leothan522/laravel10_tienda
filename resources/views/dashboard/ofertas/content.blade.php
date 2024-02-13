@if($modulo_activo)

    <div class="invoice p-3 mb-3" xmlns:wire="http://www.w3.org/1999/xhtml">

        <!-- title row -->
        <div class="row mb-3">
            <div class="col-12">
                <h3>
                    <i class="fas fa-store-alt"></i> {{ $empresa->nombre }}
                    <small class="float-right">
                        <select class="custom-select" wire:model.live="empresa_id" onchange="cambiarEmpresa()">
                            @foreach($listarEmpresas as $empresa)
                                <option value="{{ $empresa['id'] }}">{{ $empresa['text'] }}</option>
                            @endforeach
                        </select>
                    </small>
                </h3>
            </div>
        </div>

        <div class="overlay-wrapper" wire:loading wire:target="empresa_id">
            <div class="overlay">
                <div class="spinner-border text-navy" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-md-8">
            @include('dashboard.ofertas.card_table')
        </div>
        <div class="col-md-4">
            @include('dashboard.ofertas.card_form')
        </div>
    </div>


@else
    @if(!$modulo_empresa || !$modulo_articulo)
        <div class="callout callout-info">
            <h5><i class="fas fa-info"></i> Nota:</h5>
            Para que este Modulo este <span class="text-bold text-navy">Activo</span>, es Necesario previmente crear una
            <span class="text-bold @if($modulo_empresa) text-success @else text-danger @endif">Tienda</span>,
            un <span
                class="text-bold @if($modulo_empresa) text-success @else text-danger @endif">Almacen</span>
            y Tener Al menos un <span class="text-bold @if($modulo_articulo) text-success @else text-danger @endif">Articulo</span>
            Registrado.
        </div>
    @else
        <div class="callout callout-info">
            <h5><i class="fas fa-info"></i> Nota:</h5>
            El <span class="text-bold text-danger">Usuario</span> actual
            NO tiene a ninguna empresa. Contacte con su <span class="text-bold text-navy">Administrador</span>.
        </div>
    @endif
@endif
