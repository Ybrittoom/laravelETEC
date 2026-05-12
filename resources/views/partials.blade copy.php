@extends('layout')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Fixed Layout</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Layout</a></li>
                        <li class="breadcrumb-item active">Fixed Layout</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('content')
    <!-- Adicionado 'pt-3' para dar um respiro no topo e 'align-items-center' para alinhar verticalmente -->
    <div class="d-flex justify-content-between align-items-center pt-3 mb-3">
        <h2 class="mb-0">Gerenciamento de Usuário</h2>
        
        <!-- Botão de Inclusão alterado para 'btn-sm' -->
        <a href="#" class="btn btn-sm btn-primary">
            <i class="fas fa-plus fa-sm"></i> Novo Registro
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Usuários</h3>
            
            <!-- Caixa de Pesquisa -->
            <form action="#" method="GET" class="card-tools">
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

        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>
                            <a href="#">ID <i class="fas fa-sort"></i></a>
                        </th>
                        <th>
                            <a href="#">Nome <i class="fas fa-sort"></i></a>
                        </th>
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

        <div class="card-footer clearfix">
            <!-- Paginação virá aqui -->
        </div>
    </div>
@endsection