

<!DOCTYPE html>
<!-- alterado para receber a configuração de local do arquivo config/app.php através da função app()->getLocale() -->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  {{-- diretiva do Blade para "enviar" um pedaço de texto para um local específico --}}
  @section('title', 'Login')
  {{-- A diretiva @include do Blade serve para "copiar e colar" o conteúdo de um arquivo --}}
  @include('partials.head')
  {{-- A diretiva @stack do Blade permite adicionar estilos específicos de uma página --}}
  @stack('styles')
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="/"><b>{{ config('app.name', 'Laravel') }}</b></a>
    </div>

    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Entrar no sistema</p>

        {{-- alterar o link "../../index3.html" para {{ route('nome') }} para acessar o caminho da URL a ser acessada --}}
        <form action="{{ route('login.post') }}" method="post">
          @csrf

          <div class="input-group mb-3">
            <!-- acrescentado o atributo name que o servidor possa processar o valor inserido ao enviar o formulário -->
            <!-- acrescentado o atributo required tributo required para tornar o preenchimento do campo como obrigatório -->
            <input type="email" name="email" class="form-control" placeholder="E-mail" required autofocus>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>

          {{-- Campo de Senha --}}
          <div class="input-group mb-3">
            <!-- acrescentado o atributo name que o servidor possa processar o valor inserido ao enviar o formulário -->
            <!-- acrescentado o atributo required tributo required para tornar o preenchimento do campo como obrigatório -->
            <input type="password" name="password" class="form-control" placeholder="Senha" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>

          </div>

          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                {{-- Adicionado o name="remember" para o backend reconhecer --}}
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">
                  Lembre-me
                </label>
              </div>
            </div>
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Entrar</button>
            </div>
            {{-- Início do bloco de alerta caso o login falhar --}}
            {{-- Diretiva do Blade utilizada que verifica se existem mensagens de erro de validação disponíveis na requisição atual --}}
            @if ($errors->any() || session('success'))
              <div
                style="position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 9999; width: 90%; max-width: 600px;">

                @if ($errors->any())
                  <div class="alert alert-danger alert-dismissible shadow-lg fade show" role="alert">
                    <i class="icon fas fa-ban"></i>
                    <strong>Atenção:</strong> {{ $errors->first() }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                @endif

                @if (session('success'))
                  <div class="alert alert-success alert-dismissible shadow-lg fade show" role="alert">
                    <i class="icon fas fa-check"></i>
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                @endif

              </div>
            @endif
            {{-- Fim do bloco de alerta cado o login falhar --}}
          </div>
        </form>

        <div class="social-auth-links text-center mb-3">
          <p>- OU -</p>
          <a href="#" class="btn btn-block btn-primary">
            <i class="fab fa-facebook mr-2"></i> Facebook
          </a>
          <a href="#" class="btn btn-block btn-danger">
            <i class="fab fa-google-plus mr-2"></i> Google+
          </a>
        </div>

        <p class="mb-1">
          <a href="#">Esqueci minha senha</a>
        </p>
        <p class="mb-0">
          <a href="#" class="text-center">Registrar-se no sistema</a>
        </p>
      </div>
    </div>
  </div>
  {{-- A diretiva @stack permite adicionar estilos específicos de uma página --}}
  @include('partials.scripts')
  {{-- A diretiva @stack do Blade permite adicionar scripts específicos de uma página --}}
  @stack('scripts')
</body>

</html>
