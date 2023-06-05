<!-- Modal -->
<div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            {{--<div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>--}}
            <div class="modal-body">


                <div class="card card-widget widget-user-2">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header bg-primary">
                        <div class="widget-user-image">
                            <img class="img-circle elevation-2" src="{{ verImagen($modal_imagen, true) }}" alt="User Avatar" style="width: 65px; height: 65px;">
                        </div>
                        <!-- /.widget-user-image -->
                        <h4 class="widget-user-username">{{ $modal_nombre }}</h4>
                        <h6 class="widget-user-desc">{{ $modal_email }}</h6>
                    </div>
                    <div class="card-footer p-0">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <span class="nav-link">
                                    Teléfono <span class="float-right badge bg-primary">{{ $modal_telefono }}</span>
                                </span>
                            </li>
                            <li class="nav-item">
                                <span class="nav-link">
                                    Mesnajes Enviados <span class="float-right badge bg-warning">{{ $modal_mensajes }}</span>
                                </span>
                            </li>
                            <li class="nav-item">
                                <span class="nav-link">
                                    Incorporación <span class="float-right badge bg-success">{{ $modal_fecha }}</span>
                                </span>
                            </li>
                            {{--<li class="nav-item">
                                <a href="#" class="nav-link">
                                    Followers <span class="float-right badge bg-danger">842</span>
                                </a>
                            </li>--}}
                        </ul>
                    </div>
                </div>

                <div class="col-12 text-right">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cerrar</button>
                </div>


            </div>
            {{--<div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                --}}{{--<button type="button" class="btn btn-primary">Save changes</button>--}}{{--
            </div>--}}
            <div class="overlay-wrapper" wire:loading wire:target="showModal">
                <div class="overlay">
                    <div class="spinner-border text-navy" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
