<!-- Main content -->
@if($listarEmpresas)
        <div class="invoice p-3 mb-3" xmlns:wire="http://www.w3.org/1999/xhtml">

        <!-- title row -->
        <div class="row">
            <div class="col-12">
                <h3>
                    <i class="fas fa-store-alt"></i> <span class="text-uppercase">{{ $empresa->nombre }}</span>
                    <small class="float-right">
                        <select class="custom-select" wire:model.live="empresaID" onchange="changeEmpresa()">
                            @foreach($listarEmpresas as $empresa)
                                <option value="{{ $empresa['id'] }}">{{ $empresa['text'] }}</option>
                            @endforeach
                        </select>
                    </small>
                </h3>
            </div>
        </div>

        <div class="overlay-wrapper" wire:loading>
            <div class="overlay">
                <div class="spinner-grow spinner-grow-sm" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>


    </div>
@else
    @if(!$rows)
        <div class="callout callout-info">
            <h5><i class="fas fa-info"></i> Nota:</h5>
            Para que este Modulo este <span class="text-bold text-navy">Activo</span>, es Necesario previmente crear una
            <span class="text-bold text-danger">Empresa</span>
        </div>
    @else
        <div class="callout callout-info">
            <h5><i class="fas fa-info"></i> Nota:</h5>
            El <span class="text-bold text-danger">Usuario</span> actual
            NO tiene aceeso a ninguna <span class="text-bold text-danger">Empresa</span>. Contacte con su <span class="text-bold text-navy">Administrador</span>.
        </div>
    @endif

@endif
