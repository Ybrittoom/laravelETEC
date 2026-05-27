<div class="sidebar bg-white"> {{-- Painel do Usuário --}}
    <div class="user-panel mt-3 pb-3 mb-3 d-flex border-bottom">
        <div class="image">
            <img src="{{ asset('dist/img/user2-160x160.jpg') }}"
                 class="img-circle elevation-2" 
                 style="border: 2px solid #ffc107;" alt="User Image"> </div>
        <div class="info">
            <a href="#" class="d-block font-weight-bold text-dark"> {{ auth()->user()->name ?? 'Usuário' }}
            </a>
        </div>
    </div>

    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent"
            data-widget="treeview" role="menu" data-accordion="false">

            {{-- Dashboard --}}
            <li class="nav-item">
                <a href="{{ route('dashboard') }}"
                   class="nav-link {{ request()->routeIs('dashboard') ? 'active-yellow' : 'text-dark' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>

            {{-- Produtos/Bikes --}}
            <li class="nav-item {{ request()->routeIs('bikes*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ request()->routeIs('bikes*') ? 'active-yellow' : 'text-dark' }}">
                    <i class="nav-icon fas fa-bicycle"></i>
                    <p>
                        Bikes 
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('bikes.index') }}"
                           class="nav-link {{ request()->routeIs('bikes.index') ? 'text-warning font-weight-bold' : 'text-secondary' }}">
                            <i class="fas fa-list nav-icon"></i>
                            <p>Listar Bikes</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('bikes.create') }}"
                           class="nav-link {{ request()->routeIs('bikes.create') ? 'text-warning font-weight-bold' : 'text-secondary' }}">
                            <i class="fas fa-plus-circle nav-icon"></i>
                            <p>Nova Bike</p>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Usuários --}}
            <li class="nav-item {{ request()->routeIs('users*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ request()->routeIs('users*') ? 'active-yellow' : 'text-dark' }}">
                    <i class="nav-icon fas fa-users"></i>
                    <p>Usuários <i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('users') }}" class="nav-link text-secondary">
                            <i class="far fa-dot-circle nav-icon"></i>
                            <p>Listar Usuários</p>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Logout --}}
            <li class="nav-item mt-4">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-link btn btn-link text-left w-100 border-0 text-danger">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Sair do Sistema</p>
                    </button>
                </form>
            </li>

        </ul>
    </nav>
</div>

<style>
    /* Estilo para o item ativo no fundo branco */
    .active-yellow {
        background-color: #ffc107 !important; /* Fundo Amarelo */
        color: #000000 !important; /* Texto Preto para contraste */
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .nav-sidebar .nav-link:hover:not(.active-yellow) {
        background-color: #f8f9fa; /* Cinza bem clarinho no hover */
        color: #ffc107 !important; /* Ícone/Texto fica amarelo no hover */
    }

    .sidebar {
        border-right: 1px solid #dee2e6; /* Linha sutil para separar do conteúdo */
    }
</style>