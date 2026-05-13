@extends('layouts.app') {{-- Ou o seu layout de login --}}

@section('content')
<div class="register-box" style="margin: 5% auto; width: 400px;">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <h1 class="h1"><b>Chat</b> GPT 2.01</h1>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Registrar novo usuário</p>

            <form action="{{ route('register.post') }}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" name="name" class="form-control" placeholder="Nome completo" required>
                </div>
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Senha" required>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Repita a senha" required>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Registrar</button>
                    </div>
                </div>
            </form>

            <a href="{{ route('login') }}" class="text-center d-block mt-3">Já tenho uma conta</a>
        </div>
    </div>
</div>
@endsection