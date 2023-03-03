<div class="card card-navy" style="height: inherit; width: inherit; transition: all 0.15s ease 0s;">

    <div class="card-header">
        <h3 class="card-title">Crear Parametro</h3>
        <div class="card-tools">
            {{--<button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
            </button>--}}
            {{--<span class="btn btn-tool"><i class="fas fa-list"></i></span>--}}
            {{--<span class="btn btn-tool"><i class="fas fa-ban"></i> Cancelar</span>--}}
            <span class="btn btn-tool"><i class="fas fa-file"></i></span>
        </div>
    </div>

    <div class="card-body">


        <form {{--wire:submit.prevent="store"--}} xmlns:wire="http://www.w3.org/1999/xhtml">

            <div class="form-group">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text text-bold">nombre{{--<i class="fas fa-code"></i>--}}</span>
                    </div>
                    <input type="text" class="form-control" {{--wire:model.defer="nombre"--}} name="nombre" placeholder="[string]">
                    @error('nombre')
                    <span class="col-sm-12 text-sm text-bold text-danger">
                        <i class="icon fas fa-exclamation-triangle"></i>
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group text-right">
                <input type="submit" class="btn btn-block btn-success" value="Guardar">
            </div>

        </form>




    </div>

    {!! verSpinner() !!}

</div>
