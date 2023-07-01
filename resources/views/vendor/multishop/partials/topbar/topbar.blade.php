<div class="container-fluid">
    <div class="row bg-secondary py-1 px-xl-5">
        <div class="col-lg-6 d-none d-lg-block">
            <div class="d-inline-flex align-items-center h-100">
                {{--<a class="text-body mr-3" href="">About</a>--}}
                <a class="text-body mr-3" href="{{ route('web.contact') }}">Contacto</a>
                {{--<a class="text-body mr-3" href="">Help</a>
                <a class="text-body mr-3" href="">FAQs</a>--}}
                @auth
                    @if(auth()->user()->role > 0)
                        <a class="text-body mr-3" href="{{ route('dashboard') }}">Dashboard</a>
                    @endif
                @endauth
            </div>
        </div>
        <div class="col-lg-6 text-center text-lg-right">
            <div class="d-inline-flex align-items-center">
                <div class="btn-group">
                    @auth
                        <a href="{{ route('profile.show') }}" class="btn btn-sm text-dark"><i class="fas fa-user"></i> {{ Auth::user()->name }}</a>
                        <button href="#" class="btn btn-sm text-dark d-none d-lg-block" onclick="cerrarSesion()"><i class="fas fa-power-off"></i> Cerrar</button>
                        <form class="d-none" action="{{ route('logout') }}" method="post">
                            @csrf
                            <input type="submit" value="enviar" id="btn_cerrar_sesion">
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-sm text-dark"><i class="fas fa-sign-in-alt"></i> Iniciar sesión</a>
                        <a href="{{ route('register') }}" class="btn btn-sm text-dark"><i class="fas fa-user-plus"></i>  Registrarse</a>
                    @endauth
                </div>
                {{--<div class="btn-group">
                    <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">My Account</button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <button class="dropdown-item" type="button">Sign in</button>
                        <button class="dropdown-item" type="button">Sign up</button>
                    </div>
                </div>--}}
                {{--<div class="btn-group mx-2">
                    <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">USD</button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <button class="dropdown-item" type="button">EUR</button>
                        <button class="dropdown-item" type="button">GBP</button>
                        <button class="dropdown-item" type="button">CAD</button>
                    </div>
                </div>--}}
                {{--<div class="btn-group">
                    <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">EN</button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <button class="dropdown-item" type="button">FR</button>
                        <button class="dropdown-item" type="button">AR</button>
                        <button class="dropdown-item" type="button">RU</button>
                    </div>
                </div>--}}
            </div>
            <div class="d-inline-flex align-items-center d-block d-lg-none">
                <a href="" class="btn px-0 ml-2">
                    <i class="fas fa-heart text-dark"></i>
                    <span class="badge text-dark border border-dark rounded-circle" style="padding-bottom: 2px;">0</span>
                </a>
                <a href="" class="btn px-0 ml-2">
                    <i class="fas fa-shopping-cart text-dark"></i>
                    <span class="badge text-dark border border-dark rounded-circle" style="padding-bottom: 2px;">0</span>
                </a>
            </div>
        </div>
    </div>
    <div class="row align-items-center bg-light py-3 px-xl-5 d-none d-lg-flex">
        <div class="col-lg-4">
            <a href="" class="text-decoration-none">
                <span class="h1 text-uppercase text-primary bg-dark px-2">Sportec</span>
                <span class="h1 text-uppercase text-dark bg-primary px-2 ml-n1">Tienda</span>
            </a>
        </div>
        <div class="col-lg-4 col-6 text-left">
            @include('vendor.multishop.partials.topbar.form_buscar')
        </div>
        <div class="col-lg-4 col-6 text-right">
            <p class="m-0">Servicio al Cliente</p>
            <h5 class="m-0">{{ telefonoSoporte() }}</h5>
        </div>
    </div>
</div>

<div class="container-fluid d-block d-lg-none">
    <div class="row align-items-center bg-light py-3 px-xl-5">
        <div class="col-lg-4 text-left">
            @include('vendor.multishop.partials.topbar.form_buscar')
        </div>
    </div>
</div>
