<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- alterado para receber o nome da aplicação definido na variável de ambiente APP_NAME do arquivo .env através da função config() -->
<title>@yield('title') | {{ config('app.name', 'Laravel') }}</title>

<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<!-- alterar de "../../plugins/fontawesome-free/css/all.min.css" para "{{ asset('plugins/fontawesome-free/css/all.min.css') }}" -->
<link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">

especifica da login
<!-- icheck bootstrap -->
<!-- alterar de "../../plugins/icheck-bootstrap/icheck-bootstrap.min.css" para "{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}" -->
<link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
<!-- Theme style -->
<!-- alterar de "../../dist/css/adminlte.min.css" para "{{ asset('dist/css/adminlte.min.css') }}" -->
<link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">

especifica da fixed
<!-- overlayScrollbars -->
<!-- alterar de "../../plugins/overlayScrollbars/css/OverlayScrollbars.min.css" para "{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}" -->
<link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">