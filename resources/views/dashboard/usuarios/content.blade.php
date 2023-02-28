<div class="row justify-content-center">
    @if(comprobarPermisos('usuarios.create'))
        <div class="col-md-3">
            @include('dashboard.usuarios.card_form')
        </div>
    @endif
    <div class="col-md-9">
        @include('dashboard.usuarios.card_table')
        @include('dashboard.usuarios.modal_edit')
        @include('dashboard.usuarios.modal_permisos')
    </div>
</div>

@section('right-sidebar')
    @if(comprobarPermisos())
        @include('dashboard.usuarios.right-sidebar')
    @else
        @include('dashboard.right-sidebar')
    @endif
@endsection
