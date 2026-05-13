@extends('layouts.app') {{-- Ou o nome do teu layout principal --}}

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Chat Interno</div>
        <div class="card-body" style="height: 400px; overflow-y: auto;">
            @foreach($messages as $msg)
                <div class="mb-3 {{ $msg->user_id == Auth::id() ? 'text-end' : '' }}">
                    <strong>{{ $msg->user->name }}:</strong>
                    <div class="p-2 d-inline-block rounded {{ $msg->user_id == Auth::id() ? 'bg-primary text-white' : 'bg-light' }}">
                        {{ $msg->content }}
                    </div>
                    <small class="d-block text-muted">{{ $msg->created_at->format('H:i') }}</small>
                </div>
            @endforeach
        </div>
        <div class="card-footer">
            <form action="{{ route('chat.store') }}" method="POST">
                @csrf
                <div class="input-group">
                    <input type="text" name="content" class="form-control" placeholder="Escreve uma mensagem...">
                    <button class="btn btn-primary" type="submit">Enviar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection