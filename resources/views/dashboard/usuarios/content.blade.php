<div class="row justify-content-center">
    <div class="col-md-3">
        @include('dashboard.usuarios.card_form')
    </div>
    <div class="col-md-9">
        @include('dashboard.usuarios.card_table')
        @include('dashboard.usuarios.modal_edit')
        @include('dashboard.usuarios.modal_permisos')
    </div>
</div>

@section('right-sidebar')
    @include('dashboard.usuarios.right-sidebar')
@endsection
