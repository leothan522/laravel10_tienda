{{--<button type="button" class="btn btn-primary btn-sm btn-block m-1"
        data-toggle="modal" data-target="#modal-user-permisos"
    --}}{{--onclick="verRoles({{ $parametro->id }})" id="set_rol_id_{{ $parametro->id }}"--}}{{-->
    Categorias
</button>--}}

<div wire:ignore.self class="modal fade" id="modal-user-edit" xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                {{--<h4 class="modal-title">Large Modal</h4>--}}
                <button type="button" {{--wire:click="limpiar()"--}} class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">



            </div>

            {!! verSpinner() !!}

            <div class="modal-footer justify-content-end">
                <button type="button" {{--wire:click="limpiar()"--}} class="btn btn-default btn-sm" data-dismiss="modal">{{ __('Close') }}</button>
            </div>

        </div>
    </div>
</div>
