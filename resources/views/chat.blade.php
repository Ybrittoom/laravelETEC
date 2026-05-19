@extends('layout')

@section('title', 'Chat Interno')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-comments mr-2"></i>Chat Interno</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Início</a></li>
                    <li class="breadcrumb-item active">Chat</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-comments mr-1"></i> Chat Interno — todos os perfis</h3>
                        <div class="card-tools">
                            <span class="badge badge-primary">{{ $messages->count() }} mensagens</span>
                        </div>
                    </div>

                    {{-- Área de mensagens --}}
                    <div class="card-body" id="chat-box"
                         style="height: 450px; overflow-y: auto; background: #f8f9fa;">

                        @forelse($messages as $msg)
                            @php $isOwn = $msg->user_id === Auth::id(); @endphp
                            <div class="d-flex mb-3 {{ $isOwn ? 'justify-content-end' : 'justify-content-start' }}">
                                {{-- Avatar lado esquerdo (outros) --}}
                                @unless($isOwn)
                                <div class="mr-2">
                                    <span class="btn btn-sm btn-secondary rounded-circle"
                                          style="width:36px;height:36px;line-height:22px;font-weight:700;">
                                        {{ strtoupper(substr($msg->user->name ?? '?', 0, 1)) }}
                                    </span>
                                </div>
                                @endunless

                                <div style="max-width: 70%;">
                                    <small class="text-muted {{ $isOwn ? 'd-block text-right' : 'd-block' }}">
                                        {{ $isOwn ? 'Você' : ($msg->user->name ?? 'Desconhecido') }}
                                        &bull; {{ $msg->created_at->format('d/m H:i') }}
                                    </small>
                                    <div class="p-2 rounded shadow-sm
                                        {{ $isOwn ? 'bg-primary text-white' : 'bg-white border' }}"
                                         style="display: inline-block; word-break: break-word;">
                                        {{ $msg->content }}
                                    </div>
                                </div>

                                {{-- Avatar lado direito (próprio) --}}
                                @if($isOwn)
                                <div class="ml-2">
                                    <span class="btn btn-sm btn-primary rounded-circle"
                                          style="width:36px;height:36px;line-height:22px;font-weight:700;">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </span>
                                </div>
                                @endif
                            </div>
                        @empty
                            <div class="text-center text-muted py-5">
                                <i class="fas fa-comments fa-3x mb-3"></i>
                                <p>Nenhuma mensagem ainda. Seja o primeiro a escrever!</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Formulário de envio --}}
                    <div class="card-footer">
                        <form action="{{ route('chat.store') }}" method="POST" id="chat-form">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="content" id="chat-input"
                                       class="form-control @error('content') is-invalid @enderror"
                                       placeholder="Escreva uma mensagem..."
                                       autocomplete="off" maxlength="1000" required>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-paper-plane"></i> Enviar
                                    </button>
                                </div>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    // Auto-scroll para o final do chat ao carregar
    (function () {
        var box = document.getElementById('chat-box');
        if (box) box.scrollTop = box.scrollHeight;
    })();

    // Enviar com Enter (Shift+Enter = quebra de linha não se aplica em input simples)
    document.getElementById('chat-input').addEventListener('keydown', function (e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            document.getElementById('chat-form').submit();
        }
    });
</script>
@endpush