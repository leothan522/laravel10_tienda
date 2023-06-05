<div class="row" xmlns:wire="http://www.w3.org/1999/xhtml">
    <form class="row col-md-12" wire:submit.prevent="storeHoras">

        <div class="col-md-6">

            <div class="card card-outline card-navy">

                <div class="card-header">
                    <h5 class="card-title">Horario de la Tienda</h5>
                    <div class="card-tools">
                        <div class="custom-control custom-switch custom-switch-on-success float-right">
                            <input type="checkbox" class="custom-control-input" id="customSwitchHours"
                                @if($horario) checked @endif wire:click="botonHorario({{ $horario_id }})">
                            <label class="custom-control-label" for="customSwitchHours" role="button"></label>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <h1 class="profile-username text-center text-bold">
                        {{ $nombre }}
                    </h1>

                    <div class="input-group">
                        <label class="text-muted">Dias Activos</label>
                    </div>

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                              <input type="checkbox" role="button" @if($lunes) checked @endif wire:click="diasActivos('Mon', {{ $lunes }})">
                            </span>
                        </div>
                        <label class="form-control">Lunes</label>
                    </div>
                    <div class="input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text">
                          <input type="checkbox" role="button" @if($martes) checked @endif wire:click="diasActivos('Tue', {{ $martes }})">
                        </span>
                        </div>
                        <label class="form-control">Martes</label>
                    </div>
                    <div class="input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text">
                          <input type="checkbox" role="button" @if($miercoles) checked @endif wire:click="diasActivos('Wed', {{ $miercoles }})">
                        </span>
                        </div>
                        <label class="form-control">Miercoles</label>
                    </div>
                    <div class="input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text">
                          <input type="checkbox" role="button" @if($jueves) checked @endif wire:click="diasActivos('Thu', {{ $jueves }})">
                        </span>
                        </div>
                        <label class="form-control">Jueves</label>
                    </div>
                    <div class="input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text">
                          <input type="checkbox" role="button" @if($viernes) checked @endif wire:click="diasActivos('Fri', {{ $viernes }})">
                        </span>
                        </div>
                        <label class="form-control">Viernes</label>
                    </div>
                    <div class="input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text">
                          <input type="checkbox" role="button" @if($sabado) checked @endif wire:click="diasActivos('Sat', {{ $sabado }})">
                        </span>
                        </div>
                        <label class="form-control">Sabado</label>
                    </div>
                    <div class="input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text">
                          <input type="checkbox" role="button" @if($domingo) checked @endif wire:click="diasActivos('Sun', {{ $domingo }})">
                        </span>
                        </div>
                        <label class="form-control">Domingo</label>
                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-6">

            <div class="card card-outline card-navy">

                <div class="card-header">
                    <h5 class="card-title">Rango Horas</h5>
                    <div class="card-tools">
                        <span class="btn-tool"><i class="fas fa-clock"></i></span>
                    </div>
                </div>

                <div class="card-body">

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

                    <div class="form-group">
                        <label for="email">Apertura</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-clock"></i></span>
                            </div>
                            <input type="time" wire:model.defer="apertura">
                            @error('apertura')
                            <span class="col-sm-12 text-sm text-bold text-danger">
                                <i class="icon fas fa-exclamation-triangle"></i>
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">Cierre</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-clock"></i></span>
                            </div>
                            <input type="time" wire:model.defer="cierre">
                            @error('cierre')
                            <span class="col-sm-12 text-sm text-bold text-danger">
                                <i class="icon fas fa-exclamation-triangle"></i>
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>

                </div>

            </div>



        </div>

        <div class="col-md-12">
            <div class="col-md-4 float-right">
                <button type="submit" class="btn btn-block btn-success">
                    <i class="fas fa-save"></i> Guardar Horas
                </button>
            </div>
        </div>

    </form>
</div>
