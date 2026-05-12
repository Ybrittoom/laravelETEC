@extends('layout')

{{-- diretiva do Blade para "enviar" um pedaço de texto para um local específico no layout pai --}}
@section('title', 'Painel de Controle')

@section('content')
    <!-- 1. Cabeçalho da Página (Content Header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Painel de Controle</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        {{-- alterar o link "#" para {{ url('nome') }} para redirecionar para o a URL --}}
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Início</a></li>
                        <li class="breadcrumb-item active">Painel de Controle</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. Conteúdo Principal -->
    <section class="content">
        <div class="container-fluid">

            <!-- Elemento 3 -->
            <div class="col-lg-4 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        {{-- Retorna a quantidade de usuários do BD através da função compact() do método index do
                        controller DashboardController --}}
                        <h3>{{ $totalUsuarios }}</h3>
                        <p>Usuários Registrados</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    {{-- alterar o link para {{ route('nome') }} para acessar o caminho da URL a ser acessada --}}
                    <a href="{{ route('users') }}" class="small-box-footer">Mais informações <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        </div>
    </section>
@endsection