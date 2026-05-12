@extends('layout')

{{-- diretiva do Blade para "enviar" um pedaço de texto para um local específico no layout pai --}}
@section('title', 'Usuários')

@section('content')
    <!-- 1. Cabeçalho da Página (Content Header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Gerenciamento de Usuário</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        {{-- alterar o link "#" para {{ url('nome') }} para redirecionar para o a URL --}}
                         <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Início</a></li>
                        <li class="breadcrumb-item active">Usuários</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. Conteúdo Principal -->
    <section class="content">
        <div class="container-fluid">

            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <!-- Título da Lista -->
                    <h3 class="card-title mr-3">Lista de Usuários</h3>

                    <!-- Botão de Inclusão ao lado do título -->
                    <a href="{{ route('users.create') }}" class="btn btn-sm btn-success">
                        <i class="fas fa-plus"></i> Novo Registro
                    </a>

                    <!-- Caixa de Pesquisa alinhada à direita -->
                    <div class="card-tools ml-auto">
                        <form action="#" method="GET">
                            <div class="input-group input-group-sm" style="width: 250px;">
                                <input type="text" name="search" class="form-control float-right" placeholder="Pesquisar..."
                                    value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tabela -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th><a href="#">ID <i class="fas fa-sort"></i></a></th>
                                <th><a href="#">Nome <i class="fas fa-sort"></i></a></th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Nome do Usuário</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-info" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="#" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Excluir"
                                            onclick="return confirm('Tem certeza que deseja excluir?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Paginação -->
                <div class="card-footer clearfix">
                    <!-- Links de Paginação -->
                </div>
            </div>
        </div>
    </section>
@endsection
