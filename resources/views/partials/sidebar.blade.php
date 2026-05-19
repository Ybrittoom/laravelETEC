<div class="sidebar">
    {{-- Usuário logado --}}
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="{{ asset('dist/img/user2-160x160.jpg') }}"
                 class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="#" class="d-block">{{ auth()->user()->name ?? 'Usuário' }}</a>
        </div>
    </div>

    {{-- Menu --}}
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column"
            data-widget="treeview" role="menu" data-accordion="false">

            {{-- Dashboard --}}
            <li class="nav-item">
                <a href="{{ route('dashboard') }}"
                   class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>

            {{-- Usuários --}}
            <li class="nav-item {{ request()->routeIs('users*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ request()->routeIs('users*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                        Usuários
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('users') }}"
                           class="nav-link {{ request()->routeIs('users') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Listar Usuários</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('users.create') }}"
                           class="nav-link {{ request()->routeIs('users.create') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Novo Usuário</p>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Chat --}}
            <li class="nav-item">
                <a href="{{ route('chat') }}"
                   class="nav-link {{ request()->routeIs('chat') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-comments"></i>
                    <p>Chat Interno</p>
                </a>
            </li>

            {{-- Logout --}}
            <li class="nav-item" style="margin-top: auto;">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-link btn btn-link text-left w-100"
                            style="color: #c2c7d0;">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Sair</p>
                    </button>
                </form>
            </li>

        </ul>
    </nav>
</div>