<header class="navbar navbar-expand-md d-print-none">
    <div class="container-xl">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
            aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
            <a href="{{route('home')}}" class="text-decoration-none fw-bold fs-3 d-flex align-items-center gap-2" aria-label="Gerenciamento de Pedidos">
                <img src="{{asset('assets/img/logo.png')}}" alt="Logo" width="120">
            </a>
        </div>
    </div>
</header>
<header class="navbar-expand-md">
    <div class="collapse navbar-collapse" id="navbar-menu">
        <div class="navbar">
            <div class="container-xl">
                <div class="row flex-column flex-md-row flex-fill align-items-center">
                    <div class="col">
                        <!-- BEGIN NAVBAR MENU -->
                        <ul class="navbar-nav">
                            <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('home') }}">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <i class="bx bx-home icon icon-1"></i>
                                    </span>
                                    <span class="nav-link-title"> Home </span>
                                </a>
                            </li>

                            <li class="nav-item {{ request()->routeIs('clientes.*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('clientes.index') }}">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <i class="bx bx-user icon icon-1"></i>
                                    </span>
                                    <span class="nav-link-title"> Clientes </span>
                                </a>
                            </li>

                            <li class="nav-item {{ request()->routeIs('produtos.*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('produtos.index') }}">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <i class="bx bx-box icon icon-1"></i>
                                    </span>
                                    <span class="nav-link-title"> Produtos </span>
                                </a>
                            </li>

                            <li class="nav-item {{ request()->routeIs('pedidos.*') || request()->routeIs('pedidos-pagos.*') ? 'active' : '' }}">
                                <div class="dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            <i class="bx bx-cart icon icon-1"></i>
                                        </span>
                                        <span class="nav-link-title">Pedidos</span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item {{ request()->routeIs('pedidos.index') ? 'active' : '' }}" href="{{ route('pedidos.index') }}">
                                            <i class="bx bx-cart me-2"></i>
                                            Pedidos
                                        </a>
                                        <a class="dropdown-item {{ request()->routeIs('pedidos-pagos.index') ? 'active' : '' }}" href="{{ route('pedidos-pagos.index') }}">
                                            <i class="bx bx-check-circle me-2"></i>
                                            Pedidos Pagos
                                        </a>
                                    </div>
                                </div>
                            </li>

                            <li class="nav-item {{ request()->routeIs('logs.*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('logs.index') }}">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <i class="bx bx-history icon icon-1"></i>
                                    </span>
                                    <span class="nav-link-title"> Logs </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
