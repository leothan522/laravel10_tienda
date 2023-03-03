<div class="p-3">
    {{--<h5>Title</h5>
    <p>Sidebar content</p>--}}

    <ul class="nav nav-pills flex-column">
        {{--@livewire('dolar-component')--}}
        {{--<li class="dropdown-divider"></li>--}}
        <li class="nav-item">
            <span class="text-small text-muted float-right">Right-Sidebar</span>
        </li>
        <li class="nav-item">
            <a href="{{ route('chat.directo') }}" class="nav-link" target="_blank">
                <i class="fas fa-comments"></i> Chat Directo
            </a>
        </li>
        @if(auth()->user()->role == 100)
            <li class="nav-item">
                <a href="{{ route('prueba') }}" class="nav-link" target="_blank">
                    <i class="fas fa-store-alt"></i> Pagina de Prueba
                </a>
            </li>
        @endif
        {{--@if(Auth::user()->role == 100)
            <li class="dropdown-divider"></li>
            <li class="nav-item">
                <span class="text-small text-muted float-right">Android</span>
            </li>
            <li class="nav-item">
                <a href="{{ route('android.home', auth()->id()) }}" class="nav-link" target="_blank">
                    <i class="fas fa-store-alt"></i> Principal
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('android.categorias', auth()->id()) }}" class="nav-link" target="_blank">
                    <i class="fas fa-tags"></i> Categorias
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('android.tienda', auth()->id()) }}" class="nav-link" target="_blank">
                    <i class="fas fa-store"></i> Tiendas
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('android.favoritos', auth()->id()) }}" class="nav-link" target="_blank">
                    <i class="fas fa-heart"></i> Favoritos
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('android.carrito', auth()->id()) }}" class="nav-link" target="_blank">
                    <i class="fas fa-shopping-cart"></i> Carrito
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('android.pedidos', auth()->id()) }}" class="nav-link" target="_blank">
                    <i class="fas fa-shopping-bag"></i> Pedidos
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('web.perfil') }}" class="nav-link" target="_blank">
                    <i class="fas fa-user"></i> Perfil
                </a>
            </li>
        @endif--}}
        {{--<li class="dropdown-divider"></li>--}}
        {{--<li class="dropdown-divider"></li>
        <li class="nav-item">
            <a href="#" class="nav-link" target="_blank">
                <i class="fas fa-sign-out-alt"></i> Salir
            </a>
        </li>--}}


    </ul>

</div>

