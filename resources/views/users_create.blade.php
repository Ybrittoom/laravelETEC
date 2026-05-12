@extends('layout')

@section('title', 'Novo Usuário')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <h1>Cadastrar Novo Usuário</h1>
    </div>
</section>

<section class="content">
    <div class="card card-primary">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>Nome Completo</label>
                    <input type="text" name="name" class="form-control" placeholder="Digite o nome" required>
                </div>
                <div class="form-group">
                    <label>E-mail</label>
                    <input type="email" name="email" class="form-control" placeholder="Digite o e-mail" required>
                </div>
                <div class="form-group">
                    <label>Senha</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Confirmar Senha</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Salvar Usuário</button>
                <a href="{{ route('users') }}" class="btn btn-default">Cancelar</a>
            </div>
        </form>
    </div>
</section>
@endsection
