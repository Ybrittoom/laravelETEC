<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  @section('title', 'Registrar')
  @include('partials.head')
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="/"><b>{{ config('app.name', 'Laravel') }}</b></a>
    </div>

    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Registrar novo usuário</p>

        {{-- Erros de validação --}}
        @if ($errors->any() || session('success'))
          <div style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 9999; width: 90%; max-width: 600px;">
            @if ($errors->any())
              <div class="alert alert-danger alert-dismissible shadow-lg fade show" role="alert">
                <i class="icon fas fa-ban"></i>
                <strong>Atenção:</strong> {{ $errors->first() }}
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
              </div>
            @endif
            @if (session('success'))
              <div class="alert alert-success alert-dismissible shadow-lg fade show" role="alert">
                <i class="icon fas fa-check"></i>
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
              </div>
            @endif
          </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST">
          @csrf

          <div class="input-group mb-3">
            <input type="text" name="name" class="form-control"
                   placeholder="Nome completo"
                   value="{{ old('name') }}" required autofocus>
            <div class="input-group-append">
              <div class="input-group-text"><span class="fas fa-user"></span></div>
            </div>
          </div>

          <div class="input-group mb-3">
            <input type="email" name="email" class="form-control"
                   placeholder="E-mail"
                   value="{{ old('email') }}" required>
            <div class="input-group-append">
              <div class="input-group-text"><span class="fas fa-envelope"></span></div>
            </div>
          </div>

          <div class="input-group mb-3">
            <input type="password" name="password" class="form-control"
                   placeholder="Senha (mínimo 6 caracteres)" required>
            <div class="input-group-append">
              <div class="input-group-text"><span class="fas fa-lock"></span></div>
            </div>
          </div>

          <div class="input-group mb-3">
            <input type="password" name="password_confirmation" class="form-control"
                   placeholder="Confirme a senha" required>
            <div class="input-group-append">
              <div class="input-group-text"><span class="fas fa-lock"></span></div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block">Registrar</button>
            </div>
          </div>
        </form>

        <p class="mt-3 mb-0 text-center">
          <a href="{{ route('login') }}"><i class="fas fa-arrow-left mr-1"></i> Já tenho uma conta</a>
        </p>
      </div>
    </div>
  </div>

  @include('partials.scripts')
  @stack('scripts')
</body>

</html>